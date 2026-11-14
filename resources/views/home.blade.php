@extends('layouts.app')

@section('title', 'SetUp Pedia - Pusat Belanja Setup Gaming & Komputer Terlengkap')

@section('content')
<div class="space-y-10">

    <!-- 1. Flash Sale with Elegant Sage Green Background & White Typography -->
    @if($flashSales->isNotEmpty())
        <section class="rounded-3xl p-6 sm:p-8 text-white shadow-lg relative overflow-hidden"
                 style="background: linear-gradient(135deg, #476550 0%, #344c3c 100%) !important;"
                 x-data="{
                     endTime: new Date('{{ $flashSaleEndTime }}').getTime(),
                     hours: '00',
                     minutes: '00',
                     seconds: '00',
                     init() {
                         this.updateTimer();
                         setInterval(() => { this.updateTimer(); }, 1000);
                     },
                     updateTimer() {
                         const now = new Date().getTime();
                         const diff = Math.max(0, this.endTime - now);
                         const h = Math.floor(diff / (1000 * 60 * 60));
                         const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                         const s = Math.floor((diff % (1000 * 60)) / 1000);
                         this.hours = String(h).padStart(2, '0');
                         this.minutes = String(m).padStart(2, '0');
                         this.seconds = String(s).padStart(2, '0');
                     }
                 }">
            
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-white/15 border border-white/20 flex items-center justify-center text-white shadow-xs">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/></svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-0.5">
                            <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight">SUPER FLASH SALE</h2>
                            <span class="text-[11px] px-2.5 py-0.5 bg-white/20 text-white border border-white/30 rounded-md font-extrabold uppercase">TERBATAS</span>
                        </div>
                        <p class="text-xs sm:text-sm text-emerald-100/90 mt-0.5">Diskon terbesar hanya hari ini, jangan sampai kehabisan!</p>
                    </div>
                </div>

                <!-- Countdown Timer -->
                <div class="flex items-center gap-2">
                    <span class="text-xs text-emerald-100 font-bold uppercase tracking-wider mr-1 hidden sm:inline">Berakhir dalam:</span>
                    <div class="px-3 py-2 bg-white rounded-xl font-black text-emerald-950 text-base sm:text-lg shadow-md" x-text="hours">00</div>
                    <span class="text-white font-black text-lg">:</span>
                    <div class="px-3 py-2 bg-white rounded-xl font-black text-emerald-950 text-base sm:text-lg shadow-md" x-text="minutes">00</div>
                    <span class="text-white font-black text-lg">:</span>
                    <div class="px-3 py-2 bg-white rounded-xl font-black text-emerald-950 text-base sm:text-lg shadow-md" x-text="seconds">00</div>
                </div>
            </div>

            <!-- Flash Sale Products Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                @foreach($flashSales as $fs)
                    @php $p = $fs->product; @endphp
                    <div class="bg-white text-slate-900 rounded-2xl overflow-hidden shadow-md flex flex-col justify-between p-3.5 group hover:shadow-xl transition-all border border-emerald-900/10">
                        <a href="{{ route('products.show', $p->slug) }}" class="block aspect-square relative rounded-xl overflow-hidden bg-slate-50 mb-2.5">
                            <img src="{{ $p->thumbnail_url }}" alt="{{ $p->name }}"
                                 onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&auto=format&fit=crop&q=80';"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            <span class="absolute top-2 left-2 px-2 py-0.5 bg-emerald-600 text-white text-[10px] font-black rounded-md shadow-2xs">
                                FLASH SALE
                            </span>
                        </a>

                        <div>
                            <a href="{{ route('products.show', $p->slug) }}" class="text-xs sm:text-sm font-bold text-slate-800 line-clamp-2 hover:text-emerald-600 leading-tight mb-1.5">
                                {{ $p->name }}
                            </a>
                            <div class="text-sm sm:text-base font-black text-emerald-600">
                                Rp {{ number_format($fs->discount_price, 0, ',', '.') }}
                            </div>
                            <div class="text-[11px] text-slate-400 line-through mb-2.5">
                                Rp {{ number_format($p->price, 0, ',', '.') }}
                            </div>

                            <!-- Progress Bar Sold -->
                            <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden relative">
                                <div class="bg-gradient-to-r from-emerald-500 to-teal-400 h-full rounded-full transition-all duration-500"
                                     style="width: {{ $fs->percentage_sold }}%"></div>
                                <span class="absolute inset-0 flex items-center justify-center text-[9px] font-bold text-slate-600">
                                    Terjual {{ $fs->percentage_sold }}%
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <!-- 4. Laptop Gaming Flagship & Portabel -->
    @if(isset($gamingLaptops) && $gamingLaptops->isNotEmpty())
        <section class="bg-white rounded-3xl p-6 sm:p-8 shadow-2xs border border-slate-200/80">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="px-2.5 py-0.5 text-[10px] font-black uppercase tracking-wider bg-emerald-100 text-emerald-800 rounded-md">
                            KOLEKSI LAPTOP LENGKAP & GAMING
                        </span>
                        <span class="text-xs text-slate-400 font-bold hidden sm:inline">• Pilihan Ramah Kantong Mulai Rp 2 Jutaan s.d. Flagship RTX</span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Laptop Gaming & Ultrabook Pilihan</h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Pilihan laptop terlengkap, dari laptop harian terjangkau di bawah 5 jutaan hingga monster gaming bertenaga RTX</p>
                </div>
                <a href="{{ route('products.index', ['category' => 'laptop-gaming']) }}" class="text-xs sm:text-sm font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1 shrink-0">
                    <span>Lihat Semua Laptop</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 sm:gap-6">
                @foreach($gamingLaptops as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </section>
    @endif

    <!-- 5. Esports Ready & Tournament Pro Gear -->
    @if(isset($esportsGear) && $esportsGear->isNotEmpty())
        <section class="bg-white rounded-3xl p-6 sm:p-8 shadow-2xs border border-slate-200/80">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="px-2.5 py-0.5 text-[10px] font-black uppercase tracking-wider bg-indigo-100 text-indigo-800 rounded-md">
                            STANDAR TURNAMEN ESPORTS
                        </span>
                        <span class="text-xs text-slate-400 font-bold hidden sm:inline">• 8000Hz Polling & Rapid Trigger</span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Turnamen Esports & Pro Gear</h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Keyboard magnetic rapid trigger, mouse ultralight 4K/8K, monitor OLED 240Hz, dan IEM kompetitif</p>
                </div>
                <a href="{{ route('products.index', ['category' => 'keyboard-mechanical']) }}" class="text-xs sm:text-sm font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1 shrink-0">
                    <span>Lihat Semua Gear Esports</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 sm:gap-6">
                @foreach($esportsGear as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </section>
    @endif

    <!-- 7. PC Builder & Hardware Enthusiast Paradise -->
    @if(isset($pcBuilders) && $pcBuilders->isNotEmpty())
        <section class="bg-white rounded-3xl p-6 sm:p-8 shadow-2xs border border-slate-200/80">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="px-2.5 py-0.5 text-[10px] font-black uppercase tracking-wider bg-teal-100 text-teal-800 rounded-md">
                            PERFORMA MAKSIMAL
                        </span>
                        <span class="text-xs text-slate-400 font-bold hidden sm:inline">• GeForce RTX 40 Series & AMD Ryzen X3D</span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">PC Rakitan & Hardware Builder</h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Komponen PC desktop, kartu grafis high-end, RAM DDR5 6000MHz, Gen 4 NVMe & liquid cooler premium</p>
                </div>
                <a href="{{ route('products.index', ['category' => 'pc-komponen']) }}" class="text-xs sm:text-sm font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1 shrink-0">
                    <span>Eksplorasi Hardware PC</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 sm:gap-6">
                @foreach($pcBuilders as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </section>
    @endif

    <!-- 8. Official Brand Partner Strip -->
    <section class="bg-white rounded-2xl border border-slate-200/80 p-4 sm:p-6 shadow-2xs">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2 shrink-0">
                <span class="text-xs font-black text-slate-900 uppercase tracking-wider">Brand Partner Resmi:</span>
                <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 text-[10px] font-black rounded-md">100% Authorized</span>
            </div>
            <div class="flex flex-wrap items-center justify-center md:justify-end gap-3 sm:gap-6 text-xs font-black text-slate-600">
                <a href="{{ route('products.index', ['q' => 'ROG']) }}" class="px-3 py-1.5 rounded-xl bg-slate-50 hover:bg-slate-100 hover:text-emerald-600 border border-slate-100 transition">ASUS ROG</a>
                <a href="{{ route('products.index', ['q' => 'GeForce RTX']) }}" class="px-3 py-1.5 rounded-xl bg-slate-50 hover:bg-slate-100 hover:text-emerald-600 border border-slate-100 transition">NVIDIA GEFORCE</a>
                <a href="{{ route('products.index', ['q' => 'Razer']) }}" class="px-3 py-1.5 rounded-xl bg-slate-50 hover:bg-slate-100 hover:text-emerald-600 border border-slate-100 transition">RAZER</a>
                <a href="{{ route('products.index', ['q' => 'PlayStation']) }}" class="px-3 py-1.5 rounded-xl bg-slate-50 hover:bg-slate-100 hover:text-emerald-600 border border-slate-100 transition">PLAYSTATION</a>
                <a href="{{ route('products.index', ['q' => 'Logitech']) }}" class="px-3 py-1.5 rounded-xl bg-slate-50 hover:bg-slate-100 hover:text-emerald-600 border border-slate-100 transition">LOGITECH G</a>
                <a href="{{ route('products.index', ['q' => 'Corsair']) }}" class="px-3 py-1.5 rounded-xl bg-slate-50 hover:bg-slate-100 hover:text-emerald-600 border border-slate-100 transition">CORSAIR</a>
                <a href="{{ route('products.index', ['q' => 'SteelSeries']) }}" class="px-3 py-1.5 rounded-xl bg-slate-50 hover:bg-slate-100 hover:text-emerald-600 border border-slate-100 transition">STEELSERIES</a>
            </div>
        </div>
    </section>

    <!-- 9. Produk Terlaris (Best Sellers) -->
    <section>
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                    <span>Produk Terlaris</span>
                    <span class="px-2.5 py-0.5 text-xs bg-emerald-100 text-emerald-800 rounded-full font-bold">Populer</span>
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Produk paling banyak dibeli dan disukai komunitas gamers</p>
            </div>
            <a href="{{ route('products.index', ['sort' => 'popular']) }}" class="text-xs sm:text-sm font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1">
                <span>Lihat Semua</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 sm:gap-6">
            @foreach($bestSellers as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </section>

    <!-- 10. Konsol Next-Gen, Handheld & Streaming Studio -->
    @if(isset($consoleStream) && $consoleStream->isNotEmpty())
        <section class="bg-white rounded-3xl p-6 sm:p-8 shadow-2xs border border-slate-200/80">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="px-2.5 py-0.5 text-[10px] font-black uppercase tracking-wider bg-purple-100 text-purple-800 rounded-md">
                            KONSOL & BROADCAST SUITE
                        </span>
                        <span class="text-xs text-slate-400 font-bold hidden sm:inline">• 4K HDR & Portable Gaming</span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Konsol Next-Gen, Handheld & Streaming Studio</h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-0.5">PlayStation 5 Pro, Steam Deck OLED, Elgato Stream Deck, sim racing wheel & setup ruangan gaming idaman</p>
                </div>
                <a href="{{ route('products.index', ['category' => 'konsol-handheld']) }}" class="text-xs sm:text-sm font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1 shrink-0">
                    <span>Lihat Konsol & Studio</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 sm:gap-6">
                @foreach($consoleStream as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </section>
    @endif

    <!-- 9. Rekomendasi Pilihan Untuk Anda -->
    <section>
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Rekomendasi Untuk Anda</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Pilihan terbaik dikurasi khusus dengan spesifikasi dan rating tertinggi</p>
            </div>
            <a href="{{ route('products.index') }}" class="text-xs sm:text-sm font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1">
                <span>Lihat Semua</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 sm:gap-6">
            @foreach($recommended as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </section>

</div>
@endsection
