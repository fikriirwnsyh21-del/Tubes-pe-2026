@extends('layouts.app')

@section('title', 'Wishlist Saya')

@section('content')
<div class="space-y-6">

    <!-- Top Navigation / Back & Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('products.index') }}"
               class="px-3.5 py-2 rounded-xl bg-white hover:bg-slate-100 border border-slate-200 hover:border-slate-300 text-slate-700 text-xs font-bold shadow-2xs transition inline-flex items-center gap-1.5 group shrink-0">
                <svg class="w-4 h-4 text-slate-500 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Kembali</span>
            </a>

            <!-- Breadcrumb -->
            <nav class="flex items-center gap-1.5 sm:gap-2 text-xs text-slate-500 overflow-x-auto whitespace-nowrap">
                <a href="{{ route('home') }}" class="hover:text-emerald-600">Home</a>
                <span class="text-slate-300">/</span>
                <a href="{{ route('products.index') }}" class="hover:text-emerald-600">Katalog</a>
                <span class="text-slate-300">/</span>
                <span class="text-slate-900 font-bold">Wishlist Saya</span>
            </nav>
        </div>

        <a href="{{ route('home') }}" class="text-xs font-bold text-slate-500 hover:text-emerald-600 inline-flex items-center gap-1.5 transition self-start sm:self-auto">
            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <span>Ke Beranda SetUp Pedia</span>
        </a>
    </div>

    <!-- Header -->
    <div class="flex items-center justify-between bg-white p-6 rounded-3xl border border-gray-200 shadow-xs">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight">Wishlist Saya</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-0.5">Daftar produk impian yang Anda simpan</p>
        </div>
        <span class="text-xs font-bold text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
            {{ $wishlists->total() }} Produk
        </span>
    </div>

    @if($wishlists->isEmpty())
        <!-- Empty State -->
        <div class="bg-white rounded-3xl p-12 text-center border border-gray-200 shadow-xs flex flex-col items-center justify-center my-8">
            <div class="w-24 h-24 rounded-full bg-rose-50 text-rose-500 flex items-center justify-center mb-4">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            </div>
            <h2 class="text-xl font-bold text-gray-900 mb-1">Wishlist Anda Masih Kosong</h2>
            <p class="text-sm text-gray-500 max-w-sm mb-6">
                Simpan barang-barang favorit Anda di sini untuk mempermudah pembelian di waktu mendatang.
            </p>
            <a href="{{ route('products.index') }}"
               class="px-6 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-sm rounded-xl shadow-md transition">
                Jelajahi Produk Sekarang
            </a>
        </div>
    @else
        <!-- Wishlist Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 sm:gap-6">
            @foreach($wishlists as $wl)
                @php $product = $wl->product; @endphp
                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-xs hover:shadow-md transition flex flex-col justify-between">
                    <x-product-card :product="$product" />
                    
                    <!-- Action Bar -->
                    <div class="p-3 bg-gray-50 border-t border-gray-100 flex items-center gap-2">
                        <form action="{{ route('wishlist.move-to-cart', $product->id) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full py-2 bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-xs rounded-xl shadow-xs transition">
                                + Keranjang
                            </button>
                        </form>
                        <form action="{{ route('wishlist.destroy', $wl->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-gray-400 hover:text-rose-500 rounded-xl hover:bg-white transition" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="pt-6">
            {{ $wishlists->links() }}
        </div>
    @endif

</div>
@endsection
