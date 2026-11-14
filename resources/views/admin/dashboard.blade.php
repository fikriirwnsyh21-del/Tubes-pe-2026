@extends('layouts.admin')

@section('title', 'Dashboard Operasional')

@section('content')
<div class="space-y-6">

    <!-- Clean Page Header -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1.5">
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-200">
                    Dashboard Operasional
                </span>
                <span class="text-xs text-slate-400">•</span>
                <span class="text-xs font-medium text-slate-500">SetUp Pedia</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                Selamat Datang, {{ auth()->user()->name }}
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                Berikut ringkasan statistik performa katalog, pesanan masuk, dan status transaksi toko hari ini.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5 shrink-0">
            <a href="{{ route('admin.products.create') }}" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow-xs hover:shadow-sm transition inline-flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Tambah Produk</span>
            </a>
            <a href="{{ route('admin.orders.index') }}" class="px-4 py-2.5 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl text-xs font-bold transition inline-flex items-center gap-1.5">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <span>Kelola Pesanan</span>
            </a>
        </div>
    </div>

    <!-- 6 KPI Metric Cards (Mandatory Spec: Clean, high clarity, modern) -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3.5 sm:gap-4">
        <!-- 1. Total Produk -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/90 shadow-xs hover:border-slate-300 transition">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-slate-100 text-slate-600">Katalog</span>
            </div>
            <p class="text-xs font-semibold text-slate-500">Total Produk</p>
            <h3 class="text-xl sm:text-2xl font-black text-slate-900 mt-1 tracking-tight">
                {{ number_format($totalProductsCount) }}
            </h3>
            <p class="text-[11px] text-slate-400 mt-0.5">SKU Terdaftar</p>
        </div>

        <!-- 2. Total Kategori -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/90 shadow-xs hover:border-slate-300 transition">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                </div>
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-slate-100 text-slate-600">Grup</span>
            </div>
            <p class="text-xs font-semibold text-slate-500">Total Kategori</p>
            <h3 class="text-xl sm:text-2xl font-black text-slate-900 mt-1 tracking-tight">
                {{ number_format($totalCategoriesCount) }}
            </h3>
            <p class="text-[11px] text-slate-400 mt-0.5">Kategori Aktif</p>
        </div>

        <!-- 3. Total Pelanggan -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/90 shadow-xs hover:border-slate-300 transition">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-blue-50 text-blue-700">Customer</span>
            </div>
            <p class="text-xs font-semibold text-slate-500">Total Pelanggan</p>
            <h3 class="text-xl sm:text-2xl font-black text-slate-900 mt-1 tracking-tight">
                {{ number_format($totalCustomersCount) }}
            </h3>
            <p class="text-[11px] text-slate-400 mt-0.5">Akun Pembeli</p>
        </div>

        <!-- 4. Total Pesanan -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/90 shadow-xs hover:border-slate-300 transition">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-indigo-50 text-indigo-700">Semua</span>
            </div>
            <p class="text-xs font-semibold text-slate-500">Total Pesanan</p>
            <h3 class="text-xl sm:text-2xl font-black text-slate-900 mt-1 tracking-tight">
                {{ number_format($totalOrdersCount) }}
            </h3>
            <p class="text-[11px] text-slate-400 mt-0.5">Keseluruhan Order</p>
        </div>

        <!-- 5. Menunggu Pembayaran -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-amber-200/90 shadow-xs hover:border-amber-300 transition">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-[10px] font-black px-2 py-0.5 rounded-md bg-amber-100 text-amber-800">Pending</span>
            </div>
            <p class="text-xs font-semibold text-slate-500">Belum Dibayar</p>
            <h3 class="text-xl sm:text-2xl font-black text-amber-700 mt-1 tracking-tight">
                {{ number_format($pendingOrders) }}
            </h3>
            <p class="text-[11px] text-amber-600 mt-0.5">Menunggu Midtrans</p>
        </div>

        <!-- 6. Telah Dibayar -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-emerald-200/90 shadow-xs hover:border-emerald-300 transition">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-[10px] font-black px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-800">Lunas</span>
            </div>
            <p class="text-xs font-semibold text-slate-500">Telah Dibayar</p>
            <h3 class="text-xl sm:text-2xl font-black text-emerald-700 mt-1 tracking-tight">
                {{ number_format($paidOrders) }}
            </h3>
            <p class="text-[11px] text-emerald-600 mt-0.5">Siap Dikirim</p>
        </div>
    </div>

    <!-- 2 Columns: Recent Orders & Categories Breakdown -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Recent Orders (8 cols) -->
        <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
            <div class="p-5 sm:p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="font-black text-slate-900 text-base">Transaksi Terkini Toko</h2>
                    <p class="text-xs text-slate-500">Daftar transaksi pesanan pelanggan terbaru di SetUp Pedia</p>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 inline-flex items-center gap-1 transition">
                    <span>Lihat Semua</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50/75 border-b border-slate-100 text-slate-400 uppercase text-[10px] tracking-wider font-extrabold">
                        <tr>
                            <th class="py-3 px-5">No. Pesanan</th>
                            <th class="py-3 px-4">Pembeli</th>
                            <th class="py-3 px-4">Total</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentOrders as $ord)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-5 font-mono font-bold text-slate-900">
                                    {{ $ord->order_number }}
                                </td>
                                <td class="py-3.5 px-4 font-medium text-slate-700">
                                    {{ $ord->user->name }}
                                </td>
                                <td class="py-3.5 px-4 font-black text-slate-900">
                                    Rp {{ number_format($ord->grand_total, 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-4">
                                    @php
                                        $badges = [
                                            'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                                            'paid' => 'bg-blue-50 text-blue-700 border-blue-200',
                                            'processing' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                            'shipped' => 'bg-purple-50 text-purple-700 border-purple-200',
                                            'delivered' => 'bg-teal-50 text-teal-700 border-teal-200',
                                            'completed' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                            'cancelled' => 'bg-rose-50 text-rose-700 border-rose-200',
                                        ];
                                    @endphp
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase border {{ $badges[$ord->status] ?? 'bg-slate-50 text-slate-700 border-slate-200' }}">
                                        {{ $ord->status }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-5 text-right">
                                    <a href="{{ route('admin.orders.show', $ord->id) }}" class="px-3 py-1.5 bg-slate-100 hover:bg-emerald-50 hover:text-emerald-700 text-slate-700 font-bold rounded-lg text-xs transition inline-flex items-center gap-1">
                                        <span>Detail</span>
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400 text-xs">
                                    Belum ada transaksi pesanan yang tercatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top Categories Breakdown (4 cols) -->
        <div class="lg:col-span-4 bg-white rounded-2xl border border-slate-200/90 shadow-xs p-5 sm:p-6 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h2 class="font-black text-slate-900 text-base">Kategori Populer</h2>
                    <p class="text-xs text-slate-500">Jumlah produk terdaftar per kategori</p>
                </div>
                <a href="{{ route('admin.categories.index') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 transition">
                    Kelola
                </a>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($topCategories as $cat)
                    <div class="py-3 flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-800">{{ $cat->name }}</span>
                        <span class="px-2.5 py-0.5 bg-slate-100 text-slate-700 font-extrabold text-[11px] rounded-lg">
                            {{ $cat->products_count }} SKU
                        </span>
                    </div>
                @empty
                    <p class="py-4 text-center text-xs text-slate-400">Belum ada kategori yang terdaftar.</p>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
