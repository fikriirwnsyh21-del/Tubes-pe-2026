<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->order_number }} - SetUp Pedia</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; font-size: 12px; }
            .print-shadow-none { box-shadow: none !important; border: 1px solid #e2e8f0 !important; }
        }
    </style>
</head>
<body class="bg-slate-100 font-sans text-slate-900 min-h-screen p-4 sm:p-8">

    <!-- Action Bar (Hidden on Print) -->
    <div class="max-w-4xl mx-auto mb-6 flex items-center justify-between no-print">
        <a href="{{ route('orders.show', $order->id) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-emerald-600 bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-xs transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali ke Detail Pesanan</span>
        </a>
        <button onclick="window.print()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-black shadow-md transition cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            <span>Cetak Invoice (PDF)</span>
        </button>
    </div>

    <!-- Invoice Paper Container -->
    <div class="max-w-4xl mx-auto bg-white rounded-3xl p-8 sm:p-12 border border-slate-200 shadow-lg print-shadow-none space-y-8">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-6 pb-6 border-b-2 border-slate-100">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="px-2.5 py-1 bg-emerald-600 text-white font-black text-xs rounded-lg tracking-wider">SETUP</span>
                    <h1 class="text-xl font-black text-slate-900 tracking-tight">SetUp Pedia Official</h1>
                </div>
                <p class="text-xs text-slate-500">Pusat Peralatan Gaming, Peripheral, & Komputer Gaming Terpercaya</p>
                <p class="text-xs text-slate-400 mt-1">Website: http://127.0.0.1:8000 • Email: support@setuppedia.id</p>
            </div>
            <div class="sm:text-right">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block">INVOICE PESANAN</span>
                <h2 class="text-lg font-black text-slate-900 font-mono mt-0.5">{{ $order->order_number }}</h2>
                <p class="text-xs text-slate-500 mt-1">Tanggal: {{ $order->created_at->format('d F Y, H:i') }} WIB</p>
                <div class="mt-2">
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-black border {{ $order->status_badge_class }}">
                        STATUS: {{ strtoupper($order->status_label) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- 2 Columns: Billed To & Shipping Info -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 text-xs">
            <div class="space-y-1.5">
                <span class="font-black text-slate-400 uppercase tracking-wider block text-[10px]">Tujuan Pengiriman</span>
                <p class="text-sm font-black text-slate-900">{{ $order->shipping_address['recipient_name'] ?? $order->user->name }}</p>
                <p class="text-slate-600">{{ $order->shipping_address['phone'] ?? $order->user->phone }}</p>
                <p class="text-slate-600 leading-relaxed">{{ $order->shipping_address['address_line'] ?? '-' }}</p>
                <p class="text-slate-500">{{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['province'] ?? '' }} {{ $order->shipping_address['postal_code'] ?? '' }}</p>
            </div>
            <div class="space-y-1.5 sm:text-right">
                <span class="font-black text-slate-400 uppercase tracking-wider block text-[10px]">Informasi Pembayaran & Kurir</span>
                <p class="text-slate-800"><strong class="text-slate-500">Metode Bayar:</strong> {{ $order->payment?->payment_method ?? 'Midtrans Sandbox' }}</p>
                <p class="text-slate-800"><strong class="text-slate-500">Status Pembayaran:</strong> <span class="font-bold {{ $order->payment?->status === 'paid' ? 'text-emerald-600' : 'text-amber-600' }}">{{ strtoupper($order->payment?->status ?? 'PENDING') }}</span></p>
                <p class="text-slate-800"><strong class="text-slate-500">Kurir Pengiriman:</strong> {{ $order->shipping_courier }}</p>
                @if($order->tracking_number)
                    <p class="text-slate-800"><strong class="text-slate-500">No. Resi:</strong> <span class="font-mono font-bold">{{ $order->tracking_number }}</span></p>
                @endif
            </div>
        </div>

        <!-- Items Table -->
        <div class="border border-slate-200 rounded-2xl overflow-hidden">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-600 font-black uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4">No</th>
                        <th class="py-3 px-4">Nama Produk</th>
                        <th class="py-3 px-4 text-right">Harga Satuan</th>
                        <th class="py-3 px-4 text-center">Jumlah</th>
                        <th class="py-3 px-4 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($order->items as $idx => $item)
                        <tr>
                            <td class="py-3 px-4 text-slate-400 font-bold">{{ $idx + 1 }}</td>
                            <td class="py-3 px-4">
                                <p class="font-bold text-slate-900">{{ $item->product_name }}</p>
                                @if($item->variant_name)
                                    <p class="text-[10px] text-slate-500">Varian: {{ $item->variant_name }}</p>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-right font-medium text-slate-700">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="py-3 px-4 text-center font-bold text-slate-800">{{ $item->quantity }}</td>
                            <td class="py-3 px-4 text-right font-black text-slate-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Totals & Calculations -->
        <div class="flex flex-col sm:flex-row justify-between items-start gap-4 pt-2">
            <div class="text-xs text-slate-400 max-w-sm">
                <p>Catatan:</p>
                <p class="text-[11px] leading-relaxed mt-0.5">Invoice ini adalah bukti transaksi resmi yang sah. Simpan invoice ini sebagai bukti garansi dan konfirmasi pembayaran Midtrans.</p>
            </div>
            <div class="w-full sm:w-80 space-y-2 text-xs">
                <div class="flex justify-between text-slate-600">
                    <span>Subtotal Produk</span>
                    <span class="font-bold">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-slate-600">
                    <span>Ongkos Kirim</span>
                    <span class="font-bold">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                </div>
                @if($order->discount_amount > 0)
                    <div class="flex justify-between text-emerald-600 font-medium">
                        <span>Diskon Voucher</span>
                        <span class="font-bold">- Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</span>
                    </div>
                @endif
                <div class="pt-2 border-t-2 border-slate-200 flex justify-between items-baseline">
                    <span class="font-black text-slate-900 text-sm">Total Tagihan</span>
                    <span class="font-black text-emerald-600 text-lg">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="pt-8 border-t border-slate-100 text-center text-[11px] text-slate-400">
            <p>Terima kasih telah berbelanja di <strong>SetUp Pedia</strong>!</p>
        </div>

    </div>

</body>
</html>
