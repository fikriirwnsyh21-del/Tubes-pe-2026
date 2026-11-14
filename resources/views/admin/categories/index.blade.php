@extends('layouts.admin')

@section('title', 'Manajemen Kategori')

@php
    $iconMap = [
        'laptop' => '<svg class="w-4 h-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>',
        'computer-desktop' => '<svg class="w-4 h-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>',
        'cpu-chip' => '<svg class="w-4 h-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg>',
        'tv' => '<svg class="w-4 h-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M4 5h16a1 1 0 011 1v10a1 1 0 01-1 1H4a1 1 0 01-1-1V6a1 1 0 011-1z"/></svg>',
        'keyboard' => '<svg class="w-4 h-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2zm2 4h.01M10 10h.01M14 10h.01M18 10h.01M6 14h.01M18 14h.01M10 14h4"/></svg>',
        'cursor-arrow-rays' => '<svg class="w-4 h-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/></svg>',
        'speaker-wave' => '<svg class="w-4 h-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/></svg>',
        'puzzle-piece' => '<svg class="w-4 h-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/></svg>',
        'device-phone-mobile' => '<svg class="w-4 h-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>',
        'video-camera' => '<svg class="w-4 h-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>',
        'sparkles' => '<svg class="w-4 h-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>',
        'bolt' => '<svg class="w-4 h-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>',
        'fan' => '<svg class="w-4 h-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
        'steering-wheel' => '<svg class="w-4 h-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke-width="1.8"/><circle cx="12" cy="12" r="3" stroke-width="1.8"/><path stroke-linecap="round" stroke-width="1.8" d="M12 3v6m0 6v6M3 12h6m6 0h6"/></svg>',
        'wrench-screwdriver' => '<svg class="w-4 h-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>',
    ];
@endphp

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-black text-slate-900 tracking-tight">Manajemen Kategori Produk</h1>
            <p class="text-xs text-slate-500">Kelola hierarki kategori, ikon, dan struktur katalog belanja platform</p>
        </div>
    </div>

    <!-- 2 Columns: Add Form & Categories Table -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- Add Category Form (4 cols) -->
        <div class="lg:col-span-4 bg-white rounded-2xl p-6 border border-slate-200 shadow-xs space-y-4 lg:sticky lg:top-24">
            <h2 class="text-sm font-black text-slate-900 pb-2 border-b border-slate-100 uppercase tracking-wider">
                + Tambah Kategori Baru
            </h2>

            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Kategori <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" required placeholder="Contoh: Laptop Gaming"
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Kategori Induk (Opsional)</label>
                    <select name="parent_id" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs outline-none focus:ring-2 focus:ring-emerald-500">
                        <option value="">-- Kategori Utama (Tanpa Induk) --</option>
                        @foreach($parentCategories as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div x-data="{
                    open: false,
                    selected: 'laptop',
                    options: [
                        { id: 'laptop', name: 'Laptop Gaming' },
                        { id: 'computer-desktop', name: 'PC Rakitan Desktop' },
                        { id: 'cpu-chip', name: 'Hardware & Komponen PC' },
                        { id: 'tv', name: 'Monitor & Layar Display' },
                        { id: 'keyboard', name: 'Keyboard Mechanical' },
                        { id: 'cursor-arrow-rays', name: 'Mouse Gaming' },
                        { id: 'speaker-wave', name: 'Audio & Headset' },
                        { id: 'puzzle-piece', name: 'Konsol Game & Handheld' },
                        { id: 'device-phone-mobile', name: 'Smartphone Gaming' },
                        { id: 'video-camera', name: 'Streaming Gear & Kamera' },
                        { id: 'sparkles', name: 'Kursi & Meja Setup' },
                        { id: 'bolt', name: 'Storage SSD & RAM' },
                        { id: 'fan', name: 'Cooling & Power Supply' },
                        { id: 'steering-wheel', name: 'Racing Simulator & VR' },
                        { id: 'wrench-screwdriver', name: 'Aksesoris & Modding' }
                    ]
                }" class="relative">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Pilihan Ikon Kategori</label>
                    <input type="hidden" name="icon" :value="selected">

                    <!-- Custom Dropdown Trigger Button -->
                    <button type="button" @click="open = !open"
                            class="w-full flex items-center justify-between px-3 py-2.5 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl text-xs transition text-left focus:ring-2 focus:ring-emerald-500">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <span class="w-7 h-7 rounded-lg bg-white border border-slate-200 flex items-center justify-center shrink-0 text-slate-700">
                                @foreach($iconMap as $key => $svg)
                                    <span x-show="selected === '{{ $key }}'" class="flex items-center justify-center">{!! $svg !!}</span>
                                @endforeach
                            </span>
                            <span class="font-bold text-slate-800 truncate" x-text="options.find(o => o.id === selected)?.name || selected"></span>
                        </div>
                        <svg class="w-4 h-4 text-slate-400 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <!-- Dropdown Options List with Real Vector Icons -->
                    <div x-show="open" @click.outside="open = false" x-cloak
                         class="absolute left-0 right-0 top-full mt-1.5 bg-white border border-slate-200 rounded-2xl shadow-xl z-50 max-h-56 overflow-y-auto divide-y divide-slate-100 p-1">
                        @php
                            $labelMap = [
                                'laptop' => 'Laptop Gaming',
                                'computer-desktop' => 'PC Rakitan Desktop',
                                'cpu-chip' => 'Hardware & Komponen PC',
                                'tv' => 'Monitor & Layar Display',
                                'keyboard' => 'Keyboard Mechanical',
                                'cursor-arrow-rays' => 'Mouse Gaming',
                                'speaker-wave' => 'Audio & Headset',
                                'puzzle-piece' => 'Konsol Game & Handheld',
                                'device-phone-mobile' => 'Smartphone Gaming',
                                'video-camera' => 'Streaming Gear & Kamera',
                                'sparkles' => 'Kursi & Meja Setup',
                                'bolt' => 'Storage SSD & RAM',
                                'fan' => 'Cooling & Power Supply',
                                'steering-wheel' => 'Racing Simulator & VR',
                                'wrench-screwdriver' => 'Aksesoris & Modding',
                            ];
                        @endphp
                        @foreach($iconMap as $key => $svg)
                            <button type="button" @click="selected = '{{ $key }}'; open = false"
                                    class="w-full flex items-center gap-2.5 px-2.5 py-2 rounded-xl text-xs hover:bg-slate-50 transition text-left"
                                    :class="selected === '{{ $key }}' ? 'bg-emerald-50/80 font-bold text-emerald-800' : 'text-slate-700'">
                                <span class="w-7 h-7 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center shrink-0 text-slate-700">
                                    {!! $svg !!}
                                </span>
                                <span class="truncate">{{ $labelMap[$key] ?? $key }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Singkat</label>
                    <textarea name="description" rows="2" placeholder="Deskripsi kategori..."
                              class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Urutan Tampil (Sort Order)</label>
                    <input type="number" name="sort_order" value="0" min="0"
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <button type="submit"
                        class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-xs transition">
                    Simpan Kategori
                </button>
            </form>
        </div>

        <!-- Categories Table (8 cols) -->
        <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50/80 border-b border-slate-200 text-slate-400 uppercase text-[10px] tracking-wider font-black">
                        <tr>
                            <th class="py-3 px-4">Nama Kategori</th>
                            <th class="py-3 px-3">Slug</th>
                            <th class="py-3 px-3">Kategori Induk</th>
                            <th class="py-3 px-3">Jumlah Produk</th>
                            <th class="py-3 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($categories as $cat)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center shrink-0 border border-slate-200/80 shadow-2xs">
                                            @if(isset($iconMap[$cat->icon]))
                                                {!! $iconMap[$cat->icon] !!}
                                            @elseif(mb_strlen($cat->icon) <= 2 && !ctype_alnum($cat->icon))
                                                <span class="text-sm">{{ $cat->icon }}</span>
                                            @else
                                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <span class="font-bold text-slate-900 block text-xs truncate max-w-[200px]">{{ $cat->name }}</span>
                                            @if($cat->description)
                                                <p class="text-[10px] text-slate-400 truncate max-w-[200px]">{{ $cat->description }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-3">
                                    <span class="px-2 py-0.5 rounded-md bg-slate-50 border border-slate-200/80 font-mono text-[11px] text-slate-600">
                                        {{ $cat->slug }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-3 text-slate-600 font-medium">
                                    @if($cat->parent)
                                        <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 text-xs font-semibold">
                                            {{ $cat->parent->name }}
                                        </span>
                                    @else
                                        <span class="text-slate-400 text-xs">-</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-3">
                                    <span class="px-2.5 py-1 bg-slate-100 text-slate-700 font-bold rounded-lg text-[11px]">
                                        {{ $cat->products_count }} Produk
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori {{ $cat->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition" title="Hapus Kategori">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4 border-t border-slate-100">
                {{ $categories->links() }}
            </div>
        </div>

    </div>

</div>
@endsection
