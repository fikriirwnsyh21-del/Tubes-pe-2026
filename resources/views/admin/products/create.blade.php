@extends('layouts.admin')

@section('title', 'Tambah Produk Baru - Admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Top Breadcrumb & Back -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.products.index') }}" class="text-xs font-bold text-slate-500 hover:text-emerald-600 inline-flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            <span>Kembali ke Daftar Produk</span>
        </a>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-6">
        <div>
            <h1 class="text-xl font-black text-slate-900 tracking-tight">Tambah Produk Baru</h1>
            <p class="text-xs text-slate-500 mt-1">Lengkapi informasi produk sesuai ketentuan (nama, kategori, deskripsi, harga, stok, dan gambar).</p>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <!-- Nama Produk -->
            <div>
                <label for="name" class="block text-xs font-bold text-slate-700 mb-1.5">Nama Produk <span class="text-rose-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="Contoh: Keyboard Mechanical RGB Wireless"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-250 bg-slate-50 text-xs sm:text-sm text-slate-900 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/15">
                @error('name') <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Kategori Produk -->
            <div>
                <label for="category_id" class="block text-xs font-bold text-slate-700 mb-1.5">Kategori Produk <span class="text-rose-500">*</span></label>
                <select id="category_id" name="category_id" required
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-250 bg-slate-50 text-xs sm:text-sm text-slate-900 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/15 font-medium">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Deskripsi Produk -->
            <div>
                <label for="description" class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi Produk <span class="text-rose-500">*</span></label>
                <textarea id="description" name="description" rows="5" required placeholder="Tuliskan spesifikasi, fitur unggulan, kelengkapan paket, dan garansi produk..."
                          class="w-full px-3.5 py-2.5 rounded-xl border border-slate-250 bg-slate-50 text-xs sm:text-sm text-slate-900 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/15">{{ old('description') }}</textarea>
                @error('description') <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Harga, Diskon, Stok & Berat -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="price" class="block text-xs font-bold text-slate-700 mb-1.5">Harga Normal (Rp) <span class="text-rose-500">*</span></label>
                    <input type="number" id="price" name="price" value="{{ old('price') }}" required min="0" step="1000" placeholder="Contoh: 1500000"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-250 bg-slate-50 text-xs sm:text-sm text-slate-900 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/15">
                    @error('price') <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="stock" class="block text-xs font-bold text-slate-700 mb-1.5">Jumlah Stok <span class="text-rose-500">*</span></label>
                    <input type="number" id="stock" name="stock" value="{{ old('stock', 10) }}" required min="0" step="1"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-250 bg-slate-50 text-xs sm:text-sm text-slate-900 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/15">
                    @error('stock') <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="weight" class="block text-xs font-bold text-slate-700 mb-1.5">Berat (Gram)</label>
                    <input type="number" id="weight" name="weight" value="{{ old('weight', 500) }}" min="1" step="1"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-250 bg-slate-50 text-xs sm:text-sm text-slate-900 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/15">
                </div>
            </div>

            <!-- Upload Gambar Produk -->
            <div>
                <label for="images" class="block text-xs font-bold text-slate-700 mb-1.5">Unggah Foto Produk</label>
                <input type="file" id="images" name="images[]" multiple accept="image/png,image/jpeg,image/webp"
                       class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3.5 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition">
                <p class="text-[10px] text-slate-400 mt-1">Mendukung format JPG, PNG, WEBP (maksimal 2MB per foto). Anda dapat memilih lebih dari satu foto.</p>
                @error('images') <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Tombol Aksi -->
            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('admin.products.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-sm transition flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Simpan Produk Baru</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
