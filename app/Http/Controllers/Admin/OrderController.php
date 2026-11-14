<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $query = Order::with(['user', 'payment', 'items.shop'])->latest();

        if ($request->filled('status') && $request->input('status') !== 'all') {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $orders = $query->paginate(15)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(int $id): View
    {
        $order = Order::with([
            'user',
            'payment',
            'items.shop',
            'items.product.primaryImage',
            'voucherUsage.voucher',
        ])->where('id', $id)->firstOrFail();

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Memperbarui status pemrosesan dan pengiriman pesanan oleh Admin.
     * Status pembayaran Midtrans dijaga ketat agar tidak diubah sembarangan tanpa verifikasi.
     */
    public function updateStatus(\Illuminate\Http\Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $order = Order::with('payment')->where('id', $id)->firstOrFail();

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:processing,shipped,delivered,completed,cancelled'],
            'tracking_number' => ['nullable', 'string', 'max:100'],
        ]);

        $newStatus = $validated['status'];

        // Strict rule: Status pembayaran yang telah diverifikasi oleh Midtrans tidak boleh diubah menjadi berhasil secara sembarangan melalui dashboard admin.
        if ($order->status === 'pending' && in_array($newStatus, ['processing', 'shipped', 'delivered', 'completed'])) {
            $isPaid = $order->payment && $order->payment->status === 'paid';
            $isCod = $order->payment && $order->payment->payment_method === 'COD';

            if (! $isPaid && ! $isCod) {
                return back()->with('error', 'Pesanan ini masih berstatus menunggu pembayaran Midtrans. Sesuai ketentuan, status pesanan belum dapat diproses sebelum pembayaran diverifikasi oleh sistem gateway Midtrans.');
            }
        }

        $updateData = ['status' => $newStatus];
        if (! empty($validated['tracking_number'])) {
            $updateData['tracking_number'] = $validated['tracking_number'];
        }

        $order->update($updateData);

        return back()->with('success', "Status pemrosesan pesanan #{$order->order_number} berhasil diperbarui menjadi {$order->status_label}.");
    }
}
