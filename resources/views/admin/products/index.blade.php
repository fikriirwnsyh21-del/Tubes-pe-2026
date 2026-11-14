@extends('layouts.admin')

@section('title', 'Moderasi Produk Platform')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-black text-slate-900 tracking-tight">Manajemen Katalog Produk</h1>
            <p class="text-xs text-slate-500">Kelola informasi produk, harga, stok, unggah gambar, tambah produk baru, dan atur status ketersediaan.</p>
        </div>
        <div>
            <a href="{{ route('admin.products.create') }}"
               class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow-sm transition inline-flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Tambah Produk Baru</span>
            </a>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-xs flex flex-col md:flex-row items-center justify-between gap-4">
        <!-- Status Tabs -->
        <div class="flex items-center gap-2 overflow-x-auto w-full md:w-auto text-xs">
            <a href="{{ route('admin.products.index') }}"
               class="px-3 py-1.5 rounded-lg font-bold transition shrink-0 {{ !request('status') ? 'bg-emerald-50 text-emerald-700 font-black' : 'text-slate-500 hover:bg-slate-100' }}">
                Semua Produk
            </a>
            <a href="{{ route('admin.products.index', ['status' => 'active']) }}"
               class="px-3 py-1.5 rounded-lg font-bold transition shrink-0 {{ request('status') === 'active' ? 'bg-emerald-50 text-emerald-700 font-black' : 'text-slate-500 hover:bg-slate-100' }}">
                Aktif
            </a>
            <a href="{{ route('admin.products.index', ['status' => 'inactive']) }}"
               class="px-3 py-1.5 rounded-lg font-bold transition shrink-0 {{ request('status') === 'inactive' ? 'bg-rose-50 text-rose-700 font-black' : 'text-slate-500 hover:bg-slate-100' }}">
                Dinonaktifkan (Take Down)
            </a>
        </div>

        <!-- Search Form -->
        <form method="GET" action="{{ route('admin.products.index') }}" class="w-full md:w-80">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau SKU produk..."
                       class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
        </form>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50/80 border-b border-slate-200 text-slate-400 uppercase text-[10px] tracking-wider font-black">
                    <tr>
                        <th class="py-3 px-3">Produk</th>
                        <th class="py-3 px-2.5">Toko</th>
                        <th class="py-3 px-2.5">Kategori</th>
                        <th class="py-3 px-2.5 whitespace-nowrap">Harga</th>
                        <th class="py-3 px-2 text-center whitespace-nowrap">Stok</th>
                        <th class="py-3 px-2 text-center whitespace-nowrap">Status</th>
                        <th class="py-3 px-3 text-right whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($products as $p)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-3 px-3">
                                <div class="flex items-center gap-2.5 max-w-[240px] xl:max-w-[320px]">
                                    <img src="{{ $p->thumbnail_url }}" alt="{{ $p->name }}"
                                         onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&auto=format&fit=crop&q=80';"
                                         class="w-10 h-10 rounded-lg object-cover border border-slate-100 shrink-0">
                                    <div class="min-w-0 flex-1">
                                        <a href="{{ route('products.show', $p->slug) }}" target="_blank"
                                           class="font-bold text-slate-900 hover:text-emerald-600 line-clamp-2 leading-snug block text-xs"
                                           title="{{ $p->name }}">
                                            {{ $p->name }}
                                        </a>
                                        <p class="text-[10px] font-mono text-slate-400 mt-0.5 truncate">SKU: {{ $p->sku }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-2.5">
                                <div class="max-w-[130px]">
                                    <a href="{{ route('shops.show', $p->shop->slug) }}" target="_blank" class="font-semibold text-emerald-600 hover:underline block truncate text-xs" title="{{ $p->shop->name }}">
                                        {{ $p->shop->name }}
                                    </a>
                                    <p class="text-[10px] text-slate-400 truncate">{{ $p->shop->city }}</p>
                                </div>
                            </td>
                            <td class="py-3 px-2.5">
                                <div class="max-w-[110px] truncate text-slate-600 font-medium" title="{{ $p->category->name }}">
                                    {{ $p->category->name }}
                                </div>
                            </td>
                            <td class="py-3 px-2.5 font-extrabold text-slate-900 whitespace-nowrap">
                                Rp {{ number_format($p->final_price, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-2 text-center font-bold text-slate-700 whitespace-nowrap">
                                {{ $p->stock }}
                            </td>
                            <td class="py-3 px-2 text-center whitespace-nowrap">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase {{ $p->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                    {{ $p->is_active ? 'Aktif' : 'Take Down' }}
                                </span>
                            </td>
                            <td class="py-3 px-3 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.products.edit', $p->id) }}"
                                       class="px-2 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-700 hover:bg-slate-200 transition inline-flex items-center gap-1"
                                       title="Edit Produk">
                                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        <span>Edit</span>
                                    </a>

                                    <form action="{{ route('admin.products.toggle-status', $p->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-2 py-1 rounded-lg text-[11px] font-bold transition {{ $p->is_active ? 'bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200/60' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200/60' }}">
                                            {{ $p->is_active ? 'Take Down' : 'Pulihkan' }}
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.products.destroy', $p->id) }}" method="POST"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini secara permanen dari platform?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Hapus Permanen">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 border-t border-slate-100">
            {{ $products->links() }}
        </div>
    </div>

</div>
@endsection
