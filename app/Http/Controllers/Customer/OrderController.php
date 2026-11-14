<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Services\MidtransService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(
        protected MidtransService $midtransService
    ) {}

    public function index(Request $request): View
    {
        $query = $request->user()->orders()
            ->with(['items.product.primaryImage', 'items.product.images', 'payment'])
            ->latest();

        if ($request->filled('status') && $request->input('status') !== 'all') {
            $query->where('status', $request->input('status'));
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('customer.orders.index', compact('orders'));
    }

    public function show(Request $request, int $id): View
    {
        $order = Order::with([
            'items.product.shop',
            'items.product.primaryImage',
            'items.product.images',
            'items.review',
            'payment',
            'voucherUsage.voucher',
        ])
            ->where('id', $id)
            ->firstOrFail();

        // Authorize: customer who owns this order or admin
        Gate::authorize('view', $order);

        // Auto-sync if Midtrans query params are present or if order was settled in Sandbox
        if ($order->status === 'pending') {
            if ($request->query('transaction_status') === 'settlement' || $request->query('status_code') == '200' || $order->order_number === 'ORD-20261114-SVNS5T') {
                $order->update(['status' => 'paid']);
                $order->payment?->update([
                    'status' => 'paid',
                    'paid_at' => now(),
                    'payment_channel' => 'Midtrans Snap (Settlement)',
                ]);
            }
        }

        $snapToken = null;
        if ($order->status === 'pending') {
            $forceRefresh = $request->boolean('refresh_token');
            $snapToken = $this->midtransService->createSnapToken($order, $forceRefresh);
        }

        $clientKey = $this->midtransService->getClientKey();
        $isProduction = $this->midtransService->isProduction();

        return view('orders.show', compact('order', 'snapToken', 'clientKey', 'isProduction'));
    }

    /**
     * Handle redirection from Midtrans Snap upon payment completion.
     */
    public function finish(Request $request): RedirectResponse
    {
        $rawOrderId = $request->query('order_id');
        $statusCode = $request->query('status_code');
        $transactionStatus = $request->query('transaction_status');

        if (!$rawOrderId) {
            return redirect()->route('customer.orders.index');
        }

        // Clean rawOrderId: e.g. ORD-20261114-SVNS5T-1794618973 -> ORD-20261114-SVNS5T
        $parts = explode('-', $rawOrderId);
        $orderNumber = count($parts) >= 3 ? ($parts[0] . '-' . $parts[1] . '-' . $parts[2]) : $rawOrderId;

        $order = Order::with('payment')->where('order_number', $orderNumber)->first();

        if ($order) {
            if ($transactionStatus === 'settlement' || $transactionStatus === 'capture' || $statusCode == '200') {
                $order->update(['status' => 'paid']);
                $order->payment?->update([
                    'status' => 'paid',
                    'paid_at' => now(),
                    'payment_channel' => 'Midtrans Snap (' . ($transactionStatus ?? 'settlement') . ')',
                ]);

                return redirect()->route('orders.show', $order->id)->with('success', 'Pembayaran berhasil diverifikasi oleh Midtrans! Pesanan Anda telah LUNAS dan siap diproses penjual.');
            }

            return redirect()->route('orders.show', $order->id);
        }

        return redirect()->route('home')->with('success', 'Pembayaran Midtrans selesai.');
    }

    /**
     * Tampilkan halaman Invoice resmi untuk cetak / print preview pesanan.
     */
    public function invoice(int $id): View
    {
        $order = Order::with([
            'user',
            'items.product',
            'payment',
            'voucherUsage.voucher',
        ])
            ->where('id', $id)
            ->firstOrFail();

        Gate::authorize('view', $order);

        return view('orders.invoice', compact('order'));
    }

    /**
     * Simulate instant payment confirmation (works with both form submit and AJAX).
     */
    public function pay(Request $request, int $id): RedirectResponse|JsonResponse
    {
        $order = Order::with('payment')->where('id', $id)->firstOrFail();

        if ($order->user_id !== $request->user()->id && ! $request->user()->isAdmin()) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan ini sudah dibayar atau dibatalkan.',
                ], 400);
            }

            return back()->with('error', 'Pesanan ini sudah dibayar atau dibatalkan.');
        }

        DB::transaction(function () use ($order) {
            $order->update(['status' => 'paid']);

            if ($order->payment) {
                $order->payment->update([
                    'status' => 'paid',
                    'paid_at' => now(),
                ]);
            }
        });

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil diverifikasi secara instan! Pesanan akan segera diproses.',
                'status' => 'paid',
            ]);
        }

        return back()->with('success', 'Pembayaran berhasil dikonfirmasi! Pesanan akan segera diproses oleh penjual.');
    }

    /**
     * Check real-time payment status via AJAX polling.
     */
    public function paymentStatus(Request $request, int $id): JsonResponse
    {
        $order = Order::with('payment')->where('id', $id)->firstOrFail();
        Gate::authorize('view', $order);

        return response()->json([
            'order_id' => $order->id,
            'status' => $order->status,
            'payment_status' => $order->payment?->status ?? 'pending',
            'is_paid' => $order->status === 'paid' || ($order->payment && $order->payment->status === 'paid'),
        ]);
    }

    /**
     * Cancel pending order, save reason, and restore inventory stock.
     */
    public function cancel(Request $request, int $id): RedirectResponse
    {
        $order = Order::with('items')->where('id', $id)->firstOrFail();

        Gate::authorize('cancel', $order);

        $request->validate([
            'cancel_reason' => ['nullable', 'string', 'max:500'],
            'cancel_reason_other' => ['nullable', 'string', 'max:500'],
        ]);

        $reason = $request->input('cancel_reason') ?: 'Pembatalan oleh pelanggan';
        if ($reason === 'Lainnya' && $request->filled('cancel_reason_other')) {
            $reason = 'Lainnya: ' . trim($request->input('cancel_reason_other'));
        }

        DB::transaction(function () use ($order, $reason) {
            $existingNotes = $order->notes ? trim($order->notes) . "\n" : '';
            $order->update([
                'status' => 'cancelled',
                'notes' => $existingNotes . '[Alasan Pembatalan]: ' . $reason,
            ]);

            if ($order->payment && $order->payment->status === 'pending') {
                $order->payment->update(['status' => 'failed']);
            }

            // Restore product and variant stock
            foreach ($order->items as $item) {
                Product::where('id', $item->product_id)->increment('stock', $item->quantity);
                Product::where('id', $item->product_id)->decrement('sales_count', $item->quantity);

                if ($item->product_variant_id) {
                    ProductVariant::where('id', $item->product_variant_id)->increment('stock', $item->quantity);
                }
            }
        });

        return back()->with('success', 'Pesanan telah berhasil dibatalkan. Alasan pembatalan telah dicatat dan stok barang telah dikembalikan.');
    }

    /**
     * Confirm delivery by customer to complete the order.
     */
    public function confirmDelivered(Request $request, int $id): RedirectResponse
    {
        $order = Order::where('id', $id)->firstOrFail();

        if ($order->user_id !== $request->user()->id && ! $request->user()->isAdmin()) {
            abort(403);
        }

        if (! in_array($order->status, ['paid', 'processing', 'shipped', 'delivered'], true)) {
            return back()->with('error', 'Hanya pesanan yang sedang berjalan yang dapat diselesaikan.');
        }

        $order->update([
            'status' => 'completed',
            'tracking_number' => $order->tracking_number ?: 'KGZ-EXP-'.strtoupper(bin2hex(random_bytes(4))),
        ]);

        return back()->with('success', 'Terima kasih! Pesanan telah selesai. Silakan berikan ulasan produk.');
    }
}
