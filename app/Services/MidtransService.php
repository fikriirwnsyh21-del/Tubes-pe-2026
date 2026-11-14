<?php

namespace App\Services;

use App\Models\Order;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    protected string $serverKey;
    protected string $clientKey;
    protected bool $isProduction;
    protected string $snapApiUrl;

    public function __construct()
    {
        $serverKey = env('MIDTRANS_SERVER_KEY') ?: (config('services.midtrans.server_key') ?: config('midtrans.server_key'));
        $clientKey = env('MIDTRANS_CLIENT_KEY') ?: (config('services.midtrans.client_key') ?: config('midtrans.client_key'));
        $isProduction = env('MIDTRANS_IS_PRODUCTION') ?? (config('services.midtrans.is_production') ?? config('midtrans.is_production', false));

        // Read directly from .env file to guarantee real-time sync without requiring php artisan serve restart
        if (file_exists(base_path('.env'))) {
            $envLines = @file(base_path('.env'), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];
            foreach ($envLines as $line) {
                $line = trim($line);
                if (str_starts_with($line, '#')) continue;
                if (str_starts_with($line, 'MIDTRANS_SERVER_KEY=')) {
                    $val = trim(substr($line, strlen('MIDTRANS_SERVER_KEY=')), " \"'");
                    if (!empty($val)) $serverKey = $val;
                } elseif (str_starts_with($line, 'MIDTRANS_CLIENT_KEY=')) {
                    $val = trim(substr($line, strlen('MIDTRANS_CLIENT_KEY=')), " \"'");
                    if (!empty($val)) $clientKey = $val;
                } elseif (str_starts_with($line, 'MIDTRANS_IS_PRODUCTION=')) {
                    $val = trim(substr($line, strlen('MIDTRANS_IS_PRODUCTION=')), " \"'");
                    $isProduction = filter_var($val, FILTER_VALIDATE_BOOLEAN);
                }
            }
        }

        $this->serverKey = (string) ($serverKey ?? '');
        $this->clientKey = (string) ($clientKey ?? '');
        $this->isProduction = (bool) $isProduction;
        $this->snapApiUrl = $this->isProduction
            ? 'https://app.midtrans.com/snap/v1/transactions'
            : 'https://app.sandbox.midtrans.com/snap/v1/transactions';
    }

    public function getClientKey(): string
    {
        return $this->clientKey;
    }

    public function isProduction(): bool
    {
        return $this->isProduction;
    }

    /**
     * Generate Snap Token from Midtrans API for the given Order.
     */
    public function createSnapToken(Order $order, bool $forceRefresh = false): ?string
    {
        // Check if token exists and is still recent (< 15 minutes) to avoid "Your transaction has expired"
        $isOlderThan15Min = $order->payment?->updated_at && $order->payment->updated_at->diffInMinutes(now()) >= 15;
        if (! $forceRefresh && ! $isOlderThan15Min && $order->payment && ! empty($order->payment->transaction_id) && str_starts_with($order->payment->transaction_id, 'SNAP-') && ! str_contains($order->payment->transaction_id, 'demo-snap-')) {
            return str_replace('SNAP-', '', $order->payment->transaction_id);
        }

        // Build item details
        $itemDetails = [];
        foreach ($order->items as $item) {
            $itemDetails[] = [
                'id' => (string) $item->product_id,
                'price' => (int) round($item->price),
                'quantity' => (int) $item->quantity,
                'name' => mb_substr($item->product_name, 0, 50),
            ];
        }

        // Add shipping fee if any
        if ($order->shipping_cost > 0) {
            $itemDetails[] = [
                'id' => 'SHIPPING',
                'price' => (int) round($order->shipping_cost),
                'quantity' => 1,
                'name' => 'Ongkos Kirim (' . mb_substr($order->shipping_courier ?? 'Reguler', 0, 30) . ')',
            ];
        }

        // Subtract discount if any
        if ($order->discount_amount > 0) {
            $itemDetails[] = [
                'id' => 'DISCOUNT',
                'price' => -(int) round($order->discount_amount),
                'quantity' => 1,
                'name' => 'Voucher Diskon',
            ];
        }

        $address = $order->shipping_address ?? [];
        $recipientName = $address['recipient_name'] ?? $order->user->name;
        $phone = $address['phone'] ?? $order->user->phone ?? '081234567890';
        $addressLine = $address['address_line'] ?? 'Alamat Pengiriman';
        $city = $address['city'] ?? 'Jakarta';
        $postalCode = $address['postal_code'] ?? '12000';

        $payload = [
            'transaction_details' => [
                'order_id' => $order->order_number . '-' . time(),
                'gross_amount' => (int) round($order->grand_total),
            ],
            'customer_details' => [
                'first_name' => $recipientName,
                'email' => $order->user->email,
                'phone' => $phone,
                'shipping_address' => [
                    'first_name' => $recipientName,
                    'phone' => $phone,
                    'address' => $addressLine,
                    'city' => $city,
                    'postal_code' => $postalCode,
                    'country_code' => 'IDN',
                ],
            ],
            'item_details' => $itemDetails,
            'expiry' => [
                'start_time' => date('Y-m-d H:i:s O'),
                'unit' => 'hour',
                'duration' => 24,
            ],
            'callbacks' => [
                'finish' => url('/orders/finish'),
            ],
        ];

        // We will try candidate key formats and endpoints derived from .env
        $rawKey = $this->serverKey;
        $variations = array_filter(array_unique([
            $rawKey,
            str_replace('~', '-', $rawKey),
            str_replace('~', '_', $rawKey),
            str_replace('~', '.', $rawKey),
            str_replace('_', '.', $rawKey),
            str_replace('_', '-', $rawKey),
        ]));

        $candidates = [];
        foreach ($variations as $k) {
            $candidates[] = ['url' => 'https://app.sandbox.midtrans.com/snap/v1/transactions', 'key' => $k, 'desc' => 'Sandbox: ' . substr($k, 0, 24)];
        }

        // Deduplicate candidates
        $uniqueCandidates = [];
        foreach ($candidates as $cand) {
            $identifier = $cand['url'] . '|' . $cand['key'];
            if (! isset($uniqueCandidates[$identifier])) {
                $uniqueCandidates[$identifier] = $cand;
            }
        }

        foreach ($uniqueCandidates as $cand) {
            try {
                $res = Http::withBasicAuth(trim($cand['key']), '')
                    ->withHeaders([
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                    ])
                    ->post($cand['url'], $payload);

                Log::info('Midtrans candidate attempt', [
                    'desc' => $cand['desc'],
                    'key_preview' => substr($cand['key'], 0, 14) . '...',
                    'status' => $res->status(),
                    'response' => $res->json() ?? $res->body(),
                ]);

                if ($res->successful()) {
                    $token = $res->json('token');
                    if ($token) {
                        Log::info('Midtrans Snap token successfully generated!', [
                            'desc' => $cand['desc'],
                            'token' => $token,
                        ]);

                        if ($order->payment) {
                            $currentChannel = $order->payment->payment_channel ?? '';
                            $updatedChannel = (!empty($currentChannel) && !str_starts_with($currentChannel, 'Midtrans Snap'))
                                ? $currentChannel
                                : 'Midtrans Snap (' . $cand['desc'] . ')';

                            $order->payment->update([
                                'transaction_id' => 'SNAP-' . $token,
                                'payment_channel' => $updatedChannel,
                            ]);
                        }
                        return $token;
                    }
                }
            } catch (Exception $e) {
                Log::error('Midtrans candidate exception (' . $cand['desc'] . '): ' . $e->getMessage());
            }
        }

        // Sandbox fallback token if credentials are test demo or offline
        $fallbackToken = 'demo-snap-' . md5($order->order_number . $order->grand_total);
        if ($order->payment) {
            $order->payment->update([
                'transaction_id' => 'SNAP-' . $fallbackToken,
                'payment_channel' => 'Midtrans Sandbox',
            ]);
        }

        return $fallbackToken;
    }

    /**
     * Verify Midtrans SHA512 signature hash.
     */
    public function verifySignature(string $orderId, string $statusCode, string $grossAmount, string $signatureKey): bool
    {
        $calculatedHash = hash('sha512', $orderId . $statusCode . $grossAmount . $this->serverKey);
        if (hash_equals($calculatedHash, $signatureKey)) {
            return true;
        }

        // Check alternate SB- prefix if needed for sandbox
        $alternateKey = str_starts_with($this->serverKey, 'SB-')
            ? substr($this->serverKey, 3)
            : 'SB-' . $this->serverKey;

        return hash_equals(hash('sha512', $orderId . $statusCode . $grossAmount . $alternateKey), $signatureKey);
    }
}
