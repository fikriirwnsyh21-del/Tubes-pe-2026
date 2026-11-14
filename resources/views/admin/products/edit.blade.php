@extends('layouts.admin')

@section('title', 'Ubah Produk - Admin')

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
            <h1 class="text-xl font-black text-slate-900 tracking-tight">Edit Informasi Produk</h1>
            <p class="text-xs text-slate-500 mt-1">Perbarui nama, kategori, deskripsi, harga, stok, atau gambar produk.</p>
        </div>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Nama Produk -->
            <div>
                <label for="name" class="block text-xs font-bold text-slate-700 mb-1.5">Nama Produk <span class="text-rose-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-250 bg-slate-50 text-xs sm:text-sm text-slate-900 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/15">
                @error('name') <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Kategori Produk -->
            <div>
                <label for="category_id" class="block text-xs font-bold text-slate-700 mb-1.5">Kategori Produk <span class="text-rose-500">*</span></label>
                <select id="category_id" name="category_id" required
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-250 bg-slate-50 text-xs sm:text-sm text-slate-900 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/15 font-medium">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Deskripsi Produk -->
            <div>
                <label for="description" class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi Produk <span class="text-rose-500">*</span></label>
                <textarea id="description" name="description" rows="5" required
                          class="w-full px-3.5 py-2.5 rounded-xl border border-slate-250 bg-slate-50 text-xs sm:text-sm text-slate-900 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/15">{{ old('description', $product->description) }}</textarea>
                @error('description') <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Harga, Stok & Status -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="price" class="block text-xs font-bold text-slate-700 mb-1.5">Harga Normal (Rp) <span class="text-rose-500">*</span></label>
                    <input type="number" id="price" name="price" value="{{ old('price', (int) $product->price) }}" required min="0" step="1000"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-250 bg-slate-50 text-xs sm:text-sm text-slate-900 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/15">
                    @error('price') <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="stock" class="block text-xs font-bold text-slate-700 mb-1.5">Jumlah Stok <span class="text-rose-500">*</span></label>
                    <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required min="0" step="1"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-250 bg-slate-50 text-xs sm:text-sm text-slate-900 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/15">
                    @error('stock') <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="is_active" class="block text-xs font-bold text-slate-700 mb-1.5">Status Produk</label>
                    <select id="is_active" name="is_active"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-250 bg-slate-50 text-xs sm:text-sm text-slate-900 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/15 font-medium">
                        <option value="1" {{ old('is_active', $product->is_active) ? 'selected' : '' }}>Aktif (Tampil di Katalog)</option>
                        <option value="0" {{ !old('is_active', $product->is_active) ? 'selected' : '' }}>Dinonaktifkan (Take Down)</option>
                    </select>
                </div>
            </div>

            <!-- Foto Saat Ini -->
            @if($product->images->isNotEmpty())
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-2">Foto Produk Saat Ini</label>
                    <div class="flex flex-wrap gap-3">
                        @foreach($product->images as $img)
                            <div class="relative w-20 h-20 rounded-xl overflow-hidden border border-slate-200">
                                <img src="{{ $img->url }}" alt="Foto" class="w-full h-full object-cover">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Tambah Foto Baru -->
            <div>
                <label for="images" class="block text-xs font-bold text-slate-700 mb-1.5">Tambah Foto Tambahan (Opsional)</label>
                <input type="file" id="images" name="images[]" multiple accept="image/png,image/jpeg,image/webp"
                       class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3.5 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition">
            </div>

            <!-- Tombol Aksi -->
            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('admin.products.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-sm transition flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
