<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Services\MidtransService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MidtransCallbackController extends Controller
{
    public function __construct(
        protected MidtransService $midtransService
    ) {}

    /**
     * Handle HTTP Notification from Midtrans Sandbox / Production.
     */
    public function handle(Request $request): JsonResponse
    {
        $payload = $request->all();

        Log::info('Midtrans notification received', $payload);

        $orderId = $payload['order_id'] ?? null;
        $statusCode = $payload['status_code'] ?? null;
        $grossAmount = $payload['gross_amount'] ?? null;
        $signatureKey = $payload['signature_key'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $fraudStatus = $payload['fraud_status'] ?? null;
        $paymentType = $payload['payment_type'] ?? 'midtrans';

        if (! $orderId || ! $statusCode || ! $grossAmount || ! $signatureKey) {
            return response()->json(['message' => 'Invalid notification payload'], 400);
        }

        // Verify SHA512 signature key
        if (! $this->midtransService->verifySignature($orderId, $statusCode, $grossAmount, $signatureKey)) {
            Log::warning('Midtrans signature verification failed', [
                'order_id' => $orderId,
                'signature' => $signatureKey,
            ]);
            return response()->json(['message' => 'Signature verification failed'], 403);
        }

        // Find Order
        $order = Order::with(['payment', 'items'])->where('order_number', $orderId)->first();

        if (! $order) {
            return response()->json(['message' => "Order #{$orderId} not found"], 404);
        }

        DB::transaction(function () use ($order, $transactionStatus, $fraudStatus, $paymentType, $payload) {
            $currentStatus = $order->status;

            if ($transactionStatus === 'capture') {
                if ($fraudStatus === 'accept') {
                    $this->markAsPaid($order, $paymentType, $payload['transaction_id'] ?? null);
                }
            } elseif ($transactionStatus === 'settlement') {
                $this->markAsPaid($order, $paymentType, $payload['transaction_id'] ?? null);
            } elseif ($transactionStatus === 'pending') {
                if ($currentStatus !== 'paid' && $currentStatus !== 'completed') {
                    $order->update(['status' => 'pending']);
                    $order->payment?->update([
                        'status' => 'pending',
                        'payment_channel' => $paymentType,
                    ]);
                }
            } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'], true)) {
                if ($currentStatus !== 'cancelled') {
                    $order->update(['status' => 'cancelled']);

                    $order->payment?->update([
                        'status' => 'failed',
                        'payment_channel' => $paymentType,
                    ]);

                    // Restore stock
                    foreach ($order->items as $item) {
                        Product::where('id', $item->product_id)->increment('stock', $item->quantity);
                        Product::where('id', $item->product_id)->decrement('sales_count', $item->quantity);

                        if ($item->product_variant_id) {
                            ProductVariant::where('id', $item->product_variant_id)->increment('stock', $item->quantity);
                        }
                    }
                }
            }
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Payment status updated successfully',
            'order_status' => $order->fresh()->status,
        ]);
    }

    protected function markAsPaid(Order $order, string $paymentType, ?string $transactionId): void
    {
        $order->update(['status' => 'paid']);

        if ($order->payment) {
            $order->payment->update([
                'status' => 'paid',
                'payment_method' => 'Midtrans',
                'payment_channel' => strtoupper($paymentType),
                'paid_at' => now(),
                'transaction_id' => $transactionId ?: $order->payment->transaction_id,
            ]);
        }
    }
}
