<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50 overflow-x-hidden text-slate-850">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'SetUp Pedia') - Pusat Belanja Setup Gaming & Komputer Terlengkap</title>
    <meta name="description" content="@yield('meta_description', 'Pusat belanja online spesialis gear gaming, laptop gaming RTX, komponen PC rakitan, monitor 240Hz, keyboard mechanical, konsol PS5, dan aksesoris elektronik terbaik di SetUp Pedia.')">
    
    <!-- Open Graph -->
    <meta property="og:title" content="@yield('title', 'SetUp Pedia')">
    <meta property="og:description" content="@yield('meta_description', 'Pusat Belanja Setup Gaming & Tech Spesialis Terpercaya')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">

    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-screen font-sans antialiased text-slate-800 flex flex-col justify-between pb-16 md:pb-0 overflow-x-hidden"
      x-data="{
          mobileMenuOpen: false,
          categoryDropdownOpen: false,
          userDropdownOpen: false,
          searchQuery: '{{ request('q') }}',
          selectedCategory: '{{ request('category') }}',
          autocompleteOpen: false,
          suggestions: [
              'Monitor Gaming 240Hz OLED',
              'Mouse Gaming Ultralight',
              'Meja Setup & Standing Desk',
              'Keyboard Mechanical Rapid Trigger',
              'Laptop Gaming RTX 4080',
              'Laptop Budget 4 Jutaan',
              'Laptop Lenovo Ryzen 3',
              'Laptop ASUS Vivobook',
              'Laptop Acer Aspire Slim',
              'PC Rakitan Gaming Ready',
              'PlayStation 5 Pro Digital',
              'Steam Deck OLED 512GB',
              'AMD Ryzen 7 7800X3D',
              'GeForce RTX 4090 Rog Strix',
              'ASUS ROG Zephyrus G16',
              'Wooting 60HE+ Rapid Trigger',
              'Logitech G PRO X Superlight 2',
              'Samsung Odyssey OLED G8',
              'Headset 7.1 Surround & IEM',
              'Kursi Gaming Ergonomis',
              'SSD NVMe Gen4 2TB',
              'RAM DDR5 32GB 6000MHz',
              'Cooler AIO 360mm RGB',
              'Elgato Stream Deck MK.2'
          ]
      }">

    <!-- Sticky Main Header (Clear, High Contrast, Modern E-Commerce) -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200/80 shadow-xs">
        <div class="max-w-[1720px] w-full mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            
            <!-- Row: Logo, Category, Search, Actions (Naturally Scaled Up & Clear) -->
            <div class="flex items-center justify-between h-24 sm:h-28 lg:h-30 gap-4 sm:gap-6">
                
                <!-- Left: Mobile Hamburger Button -->
                <button @click="mobileMenuOpen = true"
                        type="button"
                        class="md:hidden p-2.5 text-slate-700 hover:text-emerald-600 rounded-2xl hover:bg-slate-100 transition"
                        title="Buka Menu">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>

                <!-- Clean Brand Logo (Bigger & Clearer) -->
                <a href="{{ route('home') }}" class="flex items-center gap-3.5 shrink-0 group">
                    <div class="w-13 h-13 sm:w-15 sm:h-15 rounded-2xl bg-emerald-600 flex items-center justify-center text-white shadow-md group-hover:scale-105 transition-transform">
                        <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-black text-2xl sm:text-3xl lg:text-[32px] tracking-tight text-slate-900 leading-none">
                            SetUp<span class="text-emerald-600">Pedia</span>
                        </span>
                        <span class="text-xs sm:text-[13px] text-slate-400 font-extrabold tracking-wider uppercase mt-1.5">Gaming & Tech Setup</span>
                    </div>
                </a>

                <!-- Category Button & Expanded 5-Column Mega Menu -->
                <div class="relative hidden lg:block" @click.outside="categoryDropdownOpen = false">
                    <button @click="categoryDropdownOpen = !categoryDropdownOpen"
                            type="button"
                            class="flex items-center gap-3 px-5 py-3.5 text-base font-extrabold text-slate-800 hover:text-emerald-600 rounded-2xl hover:bg-emerald-50/70 border-2 border-slate-200 transition shadow-xs cursor-pointer">
                        <svg class="w-6 h-6 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <span>Semua Kategori</span>
                        <svg class="w-5 h-5 transition-transform duration-200 text-slate-400" :class="{'rotate-180': categoryDropdownOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <!-- Simple & Clear Category Dropdown Menu (Sage Green & Putih Abu Edition) -->
                    <div x-show="categoryDropdownOpen" x-cloak
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 translate-y-1 scale-98"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         class="absolute top-full left-0 z-50 bg-white rounded-3xl shadow-2xl border border-slate-200"
                         style="width: 890px !important; min-width: 890px !important; max-width: calc(100vw - 2rem) !important; margin-top: 10px; padding: 22px 24px; box-sizing: border-box !important;">
                        
                        <!-- Top Sub-header inside Dropdown -->
                        <div class="flex items-center justify-between pb-3.5 mb-4 border-b border-slate-100" style="display: flex; align-items: center; justify-content: space-between;">
                            <div class="flex items-center gap-2" style="display: flex; align-items: center; gap: 8px;">
                                <span class="w-2.5 h-2.5 rounded-full" style="display: inline-block; width: 10px; height: 10px; border-radius: 9999px; background-color: #507159;"></span>
                                <span style="font-size: 13px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.05em; color: #1e2821;">Katalog Gear & Komponen Setup</span>
                            </div>
                            <span style="font-size: 11px; font-weight: 800; color: #2d4434; background-color: #e2ede5; border: 1px solid #c5d8cb; padding: 3px 12px; border-radius: 9999px;">
                                15 Kategori Resmi
                            </span>
                        </div>

                        <!-- 3-Column Grid with Sage Green & Putih Abu Theme -->
                        <div style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 20px;">
                            
                            <!-- Kolom 1: Komputer & Sistem -->
                            <div style="display: flex; flex-direction: column; gap: 6px;">
                                <div style="display: flex; align-items: center; justify-content: space-between; padding-bottom: 8px; margin-bottom: 4px; border-bottom: 2px solid #507159;">
                                    <span style="font-size: 12px; font-weight: 900; color: #1e2821; text-transform: uppercase; letter-spacing: 0.05em;">Komputer & Sistem</span>
                                    <span style="font-size: 10px; font-weight: 800; color: #2d4434; background: #e2ede5; border: 1px solid #c5d8cb; padding: 2px 7px; border-radius: 6px;">5 Kategori</span>
                                </div>

                                <!-- 1. Laptop Gaming -->
                                <a href="{{ route('products.index', ['category' => 'laptop-gaming']) }}" 
                                   class="group transition" 
                                   style="display: flex; align-items: center; gap: 12px; padding: 8px 10px; border-radius: 12px; text-decoration: none; background: transparent;"
                                   onmouseover="this.style.background='#eef3ef'; this.querySelector('.cat-icon').style.background='#507159'; this.querySelector('.cat-icon svg').style.color='#ffffff'; this.querySelector('.cat-icon').style.borderColor='#507159';" 
                                   onmouseout="this.style.background='transparent'; this.querySelector('.cat-icon').style.background='#edf1ee'; this.querySelector('.cat-icon svg').style.color='#507159'; this.querySelector('.cat-icon').style.borderColor='#dce3de';">
                                    <div class="cat-icon transition" style="width: 38px; height: 38px; min-width: 38px; border-radius: 10px; background: #edf1ee; border: 1px solid #dce3de; display: flex; align-items: center; justify-content: center;">
                                        <svg style="width: 20px; height: 20px; color: #507159;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    </div>
                                    <div style="display: flex; flex-direction: column; min-width: 0;">
                                        <span style="font-size: 13px; font-weight: 800; color: #1e2821; line-height: 1.25;">Laptop Gaming</span>
                                        <span style="font-size: 11px; font-weight: 500; color: #607267; margin-top: 2px;">RTX 40 Series & OLED</span>
                                    </div>
                                </a>

                                <!-- 2. PC Rakitan -->
                                <a href="{{ route('products.index', ['category' => 'pc-rakitan']) }}" 
                                   class="group transition" 
                                   style="display: flex; align-items: center; gap: 12px; padding: 8px 10px; border-radius: 12px; text-decoration: none; background: transparent;"
                                   onmouseover="this.style.background='#eef3ef'; this.querySelector('.cat-icon').style.background='#507159'; this.querySelector('.cat-icon svg').style.color='#ffffff'; this.querySelector('.cat-icon').style.borderColor='#507159';" 
                                   onmouseout="this.style.background='transparent'; this.querySelector('.cat-icon').style.background='#edf1ee'; this.querySelector('.cat-icon svg').style.color='#507159'; this.querySelector('.cat-icon').style.borderColor='#dce3de';">
                                    <div class="cat-icon transition" style="width: 38px; height: 38px; min-width: 38px; border-radius: 10px; background: #edf1ee; border: 1px solid #dce3de; display: flex; align-items: center; justify-content: center;">
                                        <svg style="width: 20px; height: 20px; color: #507159;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 4h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V5a1 1 0 011-1zm3 4h.01M8 12h.01M16 8h.01M16 12h.01M8 16h8"/></svg>
                                    </div>
                                    <div style="display: flex; flex-direction: column; min-width: 0;">
                                        <span style="font-size: 13px; font-weight: 800; color: #1e2821; line-height: 1.25;">PC Rakitan</span>
                                        <span style="font-size: 11px; font-weight: 500; color: #607267; margin-top: 2px;">Gaming Ready & Editing</span>
                                    </div>
                                </a>

                                <!-- 3. Komponen PC -->
                                <a href="{{ route('products.index', ['category' => 'pc-komponen']) }}" 
                                   class="group transition" 
                                   style="display: flex; align-items: center; gap: 12px; padding: 8px 10px; border-radius: 12px; text-decoration: none; background: transparent;"
                                   onmouseover="this.style.background='#eef3ef'; this.querySelector('.cat-icon').style.background='#507159'; this.querySelector('.cat-icon svg').style.color='#ffffff'; this.querySelector('.cat-icon').style.borderColor='#507159';" 
                                   onmouseout="this.style.background='transparent'; this.querySelector('.cat-icon').style.background='#edf1ee'; this.querySelector('.cat-icon svg').style.color='#507159'; this.querySelector('.cat-icon').style.borderColor='#dce3de';">
                                    <div class="cat-icon transition" style="width: 38px; height: 38px; min-width: 38px; border-radius: 10px; background: #edf1ee; border: 1px solid #dce3de; display: flex; align-items: center; justify-content: center;">
                                        <svg style="width: 20px; height: 20px; color: #507159;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 3v2m6-2v2M9 19v2m6-2v2M3 9h2m-2 6h2m14-6h2m-2 6h2M7 5h10a2 2 0 012 2v10a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2zm2 4h6v6H9V9z"/></svg>
                                    </div>
                                    <div style="display: flex; flex-direction: column; min-width: 0;">
                                        <span style="font-size: 13px; font-weight: 800; color: #1e2821; line-height: 1.25;">Komponen PC</span>
                                        <span style="font-size: 11px; font-weight: 500; color: #607267; margin-top: 2px;">GPU, CPU & Mobo</span>
                                    </div>
                                </a>

                                <!-- 4. Storage RAM & SSD -->
                                <a href="{{ route('products.index', ['category' => 'ram-ssd-storage']) }}" 
                                   class="group transition" 
                                   style="display: flex; align-items: center; gap: 12px; padding: 8px 10px; border-radius: 12px; text-decoration: none; background: transparent;"
                                   onmouseover="this.style.background='#eef3ef'; this.querySelector('.cat-icon').style.background='#507159'; this.querySelector('.cat-icon svg').style.color='#ffffff'; this.querySelector('.cat-icon').style.borderColor='#507159';" 
                                   onmouseout="this.style.background='transparent'; this.querySelector('.cat-icon').style.background='#edf1ee'; this.querySelector('.cat-icon svg').style.color='#507159'; this.querySelector('.cat-icon').style.borderColor='#dce3de';">
                                    <div class="cat-icon transition" style="width: 38px; height: 38px; min-width: 38px; border-radius: 10px; background: #edf1ee; border: 1px solid #dce3de; display: flex; align-items: center; justify-content: center;">
                                        <svg style="width: 20px; height: 20px; color: #507159;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                    </div>
                                    <div style="display: flex; flex-direction: column; min-width: 0;">
                                        <span style="font-size: 13px; font-weight: 800; color: #1e2821; line-height: 1.25;">Storage RAM & SSD</span>
                                        <span style="font-size: 11px; font-weight: 500; color: #607267; margin-top: 2px;">NVMe Gen4 & DDR5</span>
                                    </div>
                                </a>

                                <!-- 5. Cooling & PSU -->
                                <a href="{{ route('products.index', ['category' => 'cooling-power-supply']) }}" 
                                   class="group transition" 
                                   style="display: flex; align-items: center; gap: 12px; padding: 8px 10px; border-radius: 12px; text-decoration: none; background: transparent;"
                                   onmouseover="this.style.background='#eef3ef'; this.querySelector('.cat-icon').style.background='#507159'; this.querySelector('.cat-icon svg').style.color='#ffffff'; this.querySelector('.cat-icon').style.borderColor='#507159';" 
                                   onmouseout="this.style.background='transparent'; this.querySelector('.cat-icon').style.background='#edf1ee'; this.querySelector('.cat-icon svg').style.color='#507159'; this.querySelector('.cat-icon').style.borderColor='#dce3de';">
                                    <div class="cat-icon transition" style="width: 38px; height: 38px; min-width: 38px; border-radius: 10px; background: #edf1ee; border: 1px solid #dce3de; display: flex; align-items: center; justify-content: center;">
                                        <svg style="width: 20px; height: 20px; color: #507159;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M12 8a4 4 0 100 8 4 4 0 000-8z"/></svg>
                                    </div>
                                    <div style="display: flex; flex-direction: column; min-width: 0;">
                                        <span style="font-size: 13px; font-weight: 800; color: #1e2821; line-height: 1.25;">Cooling & PSU</span>
                                        <span style="font-size: 11px; font-weight: 500; color: #607267; margin-top: 2px;">Liquid AIO & 80+ Gold</span>
                                    </div>
                                </a>
                            </div>

                            <!-- Kolom 2: Periferal Gaming -->
                            <div style="display: flex; flex-direction: column; gap: 6px;">
                                <div style="display: flex; align-items: center; justify-content: space-between; padding-bottom: 8px; margin-bottom: 4px; border-bottom: 2px solid #507159;">
                                    <span style="font-size: 12px; font-weight: 900; color: #1e2821; text-transform: uppercase; letter-spacing: 0.05em;">Periferal Gaming</span>
                                    <span style="font-size: 10px; font-weight: 800; color: #2d4434; background: #e2ede5; border: 1px solid #c5d8cb; padding: 2px 7px; border-radius: 6px;">5 Kategori</span>
                                </div>

                                <!-- 6. Keyboard Mechanical -->
                                <a href="{{ route('products.index', ['category' => 'keyboard-mechanical']) }}" 
                                   class="group transition" 
                                   style="display: flex; align-items: center; gap: 12px; padding: 8px 10px; border-radius: 12px; text-decoration: none; background: transparent;"
                                   onmouseover="this.style.background='#eef3ef'; this.querySelector('.cat-icon').style.background='#507159'; this.querySelector('.cat-icon svg').style.color='#ffffff'; this.querySelector('.cat-icon').style.borderColor='#507159';" 
                                   onmouseout="this.style.background='transparent'; this.querySelector('.cat-icon').style.background='#edf1ee'; this.querySelector('.cat-icon svg').style.color='#507159'; this.querySelector('.cat-icon').style.borderColor='#dce3de';">
                                    <div class="cat-icon transition" style="width: 38px; height: 38px; min-width: 38px; border-radius: 10px; background: #edf1ee; border: 1px solid #dce3de; display: flex; align-items: center; justify-content: center;">
                                        <svg style="width: 20px; height: 20px; color: #507159;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2zm3 4h.01M10 10h.01M14 10h.01M17 10h.01M7 14h10"/></svg>
                                    </div>
                                    <div style="display: flex; flex-direction: column; min-width: 0;">
                                        <span style="font-size: 13px; font-weight: 800; color: #1e2821; line-height: 1.25;">Keyboard Mechanical</span>
                                        <span style="font-size: 11px; font-weight: 500; color: #607267; margin-top: 2px;">Rapid Trigger & Custom</span>
                                    </div>
                                </a>

                                <!-- 7. Mouse Gaming -->
                                <a href="{{ route('products.index', ['category' => 'mouse-gaming']) }}" 
                                   class="group transition" 
                                   style="display: flex; align-items: center; gap: 12px; padding: 8px 10px; border-radius: 12px; text-decoration: none; background: transparent;"
                                   onmouseover="this.style.background='#eef3ef'; this.querySelector('.cat-icon').style.background='#507159'; this.querySelector('.cat-icon svg').style.color='#ffffff'; this.querySelector('.cat-icon').style.borderColor='#507159';" 
                                   onmouseout="this.style.background='transparent'; this.querySelector('.cat-icon').style.background='#edf1ee'; this.querySelector('.cat-icon svg').style.color='#507159'; this.querySelector('.cat-icon').style.borderColor='#dce3de';">
                                    <div class="cat-icon transition" style="width: 38px; height: 38px; min-width: 38px; border-radius: 10px; background: #edf1ee; border: 1px solid #dce3de; display: flex; align-items: center; justify-content: center;">
                                        <svg style="width: 20px; height: 20px; color: #507159;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3a6 6 0 00-6 6v6a6 6 0 0012 0V9a6 6 0 00-6-6zm0 0v5"/></svg>
                                    </div>
                                    <div style="display: flex; flex-direction: column; min-width: 0;">
                                        <span style="font-size: 13px; font-weight: 800; color: #1e2821; line-height: 1.25;">Mouse Gaming</span>
                                        <span style="font-size: 11px; font-weight: 500; color: #607267; margin-top: 2px;">Ultralight 4K/8K Hz</span>
                                    </div>
                                </a>

                                <!-- 8. Monitor Gaming -->
                                <a href="{{ route('products.index', ['category' => 'monitor-gaming']) }}" 
                                   class="group transition" 
                                   style="display: flex; align-items: center; gap: 12px; padding: 8px 10px; border-radius: 12px; text-decoration: none; background: transparent;"
                                   onmouseover="this.style.background='#eef3ef'; this.querySelector('.cat-icon').style.background='#507159'; this.querySelector('.cat-icon svg').style.color='#ffffff'; this.querySelector('.cat-icon').style.borderColor='#507159';" 
                                   onmouseout="this.style.background='transparent'; this.querySelector('.cat-icon').style.background='#edf1ee'; this.querySelector('.cat-icon svg').style.color='#507159'; this.querySelector('.cat-icon').style.borderColor='#dce3de';">
                                    <div class="cat-icon transition" style="width: 38px; height: 38px; min-width: 38px; border-radius: 10px; background: #edf1ee; border: 1px solid #dce3de; display: flex; align-items: center; justify-content: center;">
                                        <svg style="width: 20px; height: 20px; color: #507159;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 5h18a2 2 0 012 2v8a2 2 0 01-2 2H3a2 2 0 01-2-2V7a2 2 0 012-2z"/></svg>
                                    </div>
                                    <div style="display: flex; flex-direction: column; min-width: 0;">
                                        <span style="font-size: 13px; font-weight: 800; color: #1e2821; line-height: 1.25;">Monitor Gaming</span>
                                        <span style="font-size: 11px; font-weight: 500; color: #607267; margin-top: 2px;">240Hz, 4K & OLED</span>
                                    </div>
                                </a>

                                <!-- 9. Audio & Headset -->
                                <a href="{{ route('products.index', ['category' => 'audio-headset']) }}" 
                                   class="group transition" 
                                   style="display: flex; align-items: center; gap: 12px; padding: 8px 10px; border-radius: 12px; text-decoration: none; background: transparent;"
                                   onmouseover="this.style.background='#eef3ef'; this.querySelector('.cat-icon').style.background='#507159'; this.querySelector('.cat-icon svg').style.color='#ffffff'; this.querySelector('.cat-icon').style.borderColor='#507159';" 
                                   onmouseout="this.style.background='transparent'; this.querySelector('.cat-icon').style.background='#edf1ee'; this.querySelector('.cat-icon svg').style.color='#507159'; this.querySelector('.cat-icon').style.borderColor='#dce3de';">
                                    <div class="cat-icon transition" style="width: 38px; height: 38px; min-width: 38px; border-radius: 10px; background: #edf1ee; border: 1px solid #dce3de; display: flex; align-items: center; justify-content: center;">
                                        <svg style="width: 20px; height: 20px; color: #507159;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 18v-6a9 9 0 0118 0v6M3 18a3 3 0 003 3h1a2 2 0 002-2v-4a2 2 0 00-2-2H4a1 1 0 00-1 1v4zm18 0a3 3 0 01-3 3h-1a2 2 0 01-2-2v-4a2 2 0 012-2h3a1 1 0 011 1v4z"/></svg>
                                    </div>
                                    <div style="display: flex; flex-direction: column; min-width: 0;">
                                        <span style="font-size: 13px; font-weight: 800; color: #1e2821; line-height: 1.25;">Audio & Headset</span>
                                        <span style="font-size: 11px; font-weight: 500; color: #607267; margin-top: 2px;">7.1 Surround & IEM</span>
                                    </div>
                                </a>

                                <!-- 10. Aksesoris & Modding -->
                                <a href="{{ route('products.index', ['category' => 'aksesoris-gaming']) }}" 
                                   class="group transition" 
                                   style="display: flex; align-items: center; gap: 12px; padding: 8px 10px; border-radius: 12px; text-decoration: none; background: transparent;"
                                   onmouseover="this.style.background='#eef3ef'; this.querySelector('.cat-icon').style.background='#507159'; this.querySelector('.cat-icon svg').style.color='#ffffff'; this.querySelector('.cat-icon').style.borderColor='#507159';" 
                                   onmouseout="this.style.background='transparent'; this.querySelector('.cat-icon').style.background='#edf1ee'; this.querySelector('.cat-icon svg').style.color='#507159'; this.querySelector('.cat-icon').style.borderColor='#dce3de';">
                                    <div class="cat-icon transition" style="width: 38px; height: 38px; min-width: 38px; border-radius: 10px; background: #edf1ee; border: 1px solid #dce3de; display: flex; align-items: center; justify-content: center;">
                                        <svg style="width: 20px; height: 20px; color: #507159;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </div>
                                    <div style="display: flex; flex-direction: column; min-width: 0;">
                                        <span style="font-size: 13px; font-weight: 800; color: #1e2821; line-height: 1.25;">Aksesoris & Modding</span>
                                        <span style="font-size: 11px; font-weight: 500; color: #607267; margin-top: 2px;">Deskmat, Switch & Kabel</span>
                                    </div>
                                </a>
                            </div>

                            <!-- Kolom 3: Setup & Entertainment -->
                            <div style="display: flex; flex-direction: column; gap: 6px;">
                                <div style="display: flex; align-items: center; justify-content: space-between; padding-bottom: 8px; margin-bottom: 4px; border-bottom: 2px solid #507159;">
                                    <span style="font-size: 12px; font-weight: 900; color: #1e2821; text-transform: uppercase; letter-spacing: 0.05em;">Konsol & Setup Room</span>
                                    <span style="font-size: 10px; font-weight: 800; color: #2d4434; background: #e2ede5; border: 1px solid #c5d8cb; padding: 2px 7px; border-radius: 6px;">5 Kategori</span>
                                </div>

                                <!-- 11. Konsol & Handheld -->
                                <a href="{{ route('products.index', ['category' => 'konsol-handheld']) }}" 
                                   class="group transition" 
                                   style="display: flex; align-items: center; gap: 12px; padding: 8px 10px; border-radius: 12px; text-decoration: none; background: transparent;"
                                   onmouseover="this.style.background='#eef3ef'; this.querySelector('.cat-icon').style.background='#507159'; this.querySelector('.cat-icon svg').style.color='#ffffff'; this.querySelector('.cat-icon').style.borderColor='#507159';" 
                                   onmouseout="this.style.background='transparent'; this.querySelector('.cat-icon').style.background='#edf1ee'; this.querySelector('.cat-icon svg').style.color='#507159'; this.querySelector('.cat-icon').style.borderColor='#dce3de';">
                                    <div class="cat-icon transition" style="width: 38px; height: 38px; min-width: 38px; border-radius: 10px; background: #edf1ee; border: 1px solid #dce3de; display: flex; align-items: center; justify-content: center;">
                                        <svg style="width: 20px; height: 20px; color: #507159;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 10h.01M17 12h.01M7 10h4M9 8v4M6.5 19l1.8-6.3A3 3 0 0111.2 10h1.6a3 3 0 012.9 2.7L17.5 19a2 2 0 01-3.4 1.4l-1.3-1.4h-1.6l-1.3 1.4A2 2 0 016.5 19z"/></svg>
                                    </div>
                                    <div style="display: flex; flex-direction: column; min-width: 0;">
                                        <span style="font-size: 13px; font-weight: 800; color: #1e2821; line-height: 1.25;">Konsol & Handheld</span>
                                        <span style="font-size: 11px; font-weight: 500; color: #607267; margin-top: 2px;">PS5 & Steam Deck</span>
                                    </div>
                                </a>

                                <!-- 12. Smartphone Gaming -->
                                <a href="{{ route('products.index', ['category' => 'smartphone-gaming']) }}" 
                                   class="group transition" 
                                   style="display: flex; align-items: center; gap: 12px; padding: 8px 10px; border-radius: 12px; text-decoration: none; background: transparent;"
                                   onmouseover="this.style.background='#eef3ef'; this.querySelector('.cat-icon').style.background='#507159'; this.querySelector('.cat-icon svg').style.color='#ffffff'; this.querySelector('.cat-icon').style.borderColor='#507159';" 
                                   onmouseout="this.style.background='transparent'; this.querySelector('.cat-icon').style.background='#edf1ee'; this.querySelector('.cat-icon svg').style.color='#507159'; this.querySelector('.cat-icon').style.borderColor='#dce3de';">
                                    <div class="cat-icon transition" style="width: 38px; height: 38px; min-width: 38px; border-radius: 10px; background: #edf1ee; border: 1px solid #dce3de; display: flex; align-items: center; justify-content: center;">
                                        <svg style="width: 20px; height: 20px; color: #507159;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 18h.01M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z"/></svg>
                                    </div>
                                    <div style="display: flex; flex-direction: column; min-width: 0;">
                                        <span style="font-size: 13px; font-weight: 800; color: #1e2821; line-height: 1.25;">Smartphone Gaming</span>
                                        <span style="font-size: 11px; font-weight: 500; color: #607267; margin-top: 2px;">ROG Phone & Cooler</span>
                                    </div>
                                </a>

                                <!-- 13. Streaming Gear -->
                                <a href="{{ route('products.index', ['category' => 'streaming-gear']) }}" 
                                   class="group transition" 
                                   style="display: flex; align-items: center; gap: 12px; padding: 8px 10px; border-radius: 12px; text-decoration: none; background: transparent;"
                                   onmouseover="this.style.background='#eef3ef'; this.querySelector('.cat-icon').style.background='#507159'; this.querySelector('.cat-icon svg').style.color='#ffffff'; this.querySelector('.cat-icon').style.borderColor='#507159';" 
                                   onmouseout="this.style.background='transparent'; this.querySelector('.cat-icon').style.background='#edf1ee'; this.querySelector('.cat-icon svg').style.color='#507159'; this.querySelector('.cat-icon').style.borderColor='#dce3de';">
                                    <div class="cat-icon transition" style="width: 38px; height: 38px; min-width: 38px; border-radius: 10px; background: #edf1ee; border: 1px solid #dce3de; display: flex; align-items: center; justify-content: center;">
                                        <svg style="width: 20px; height: 20px; color: #507159;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                    </div>
                                    <div style="display: flex; flex-direction: column; min-width: 0;">
                                        <span style="font-size: 13px; font-weight: 800; color: #1e2821; line-height: 1.25;">Streaming Gear</span>
                                        <span style="font-size: 11px; font-weight: 500; color: #607267; margin-top: 2px;">Elgato & Mic XLR</span>
                                    </div>
                                </a>

                                <!-- 14. Kursi & Meja Setup -->
                                <a href="{{ route('products.index', ['category' => 'kursi-setup-meja']) }}" 
                                   class="group transition" 
                                   style="display: flex; align-items: center; gap: 12px; padding: 8px 10px; border-radius: 12px; text-decoration: none; background: transparent;"
                                   onmouseover="this.style.background='#eef3ef'; this.querySelector('.cat-icon').style.background='#507159'; this.querySelector('.cat-icon svg').style.color='#ffffff'; this.querySelector('.cat-icon').style.borderColor='#507159';" 
                                   onmouseout="this.style.background='transparent'; this.querySelector('.cat-icon').style.background='#edf1ee'; this.querySelector('.cat-icon svg').style.color='#507159'; this.querySelector('.cat-icon').style.borderColor='#dce3de';">
                                    <div class="cat-icon transition" style="width: 38px; height: 38px; min-width: 38px; border-radius: 10px; background: #edf1ee; border: 1px solid #dce3de; display: flex; align-items: center; justify-content: center;">
                                        <svg style="width: 20px; height: 20px; color: #507159;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 3v10a4 4 0 004 4h6a4 4 0 004-4V3M12 17v4m-4 0h8M9 7h6"/></svg>
                                    </div>
                                    <div style="display: flex; flex-direction: column; min-width: 0;">
                                        <span style="font-size: 13px; font-weight: 800; color: #1e2821; line-height: 1.25;">Kursi & Meja Setup</span>
                                        <span style="font-size: 11px; font-weight: 500; color: #607267; margin-top: 2px;">Ergonomis & Desk</span>
                                    </div>
                                </a>

                                <!-- 15. Racing Sim & VR -->
                                <a href="{{ route('products.index', ['category' => 'racing-sim-vr']) }}" 
                                   class="group transition" 
                                   style="display: flex; align-items: center; gap: 12px; padding: 8px 10px; border-radius: 12px; text-decoration: none; background: transparent;"
                                   onmouseover="this.style.background='#eef3ef'; this.querySelector('.cat-icon').style.background='#507159'; this.querySelector('.cat-icon svg').style.color='#ffffff'; this.querySelector('.cat-icon').style.borderColor='#507159';" 
                                   onmouseout="this.style.background='transparent'; this.querySelector('.cat-icon').style.background='#edf1ee'; this.querySelector('.cat-icon svg').style.color='#507159'; this.querySelector('.cat-icon').style.borderColor='#dce3de';">
                                    <div class="cat-icon transition" style="width: 38px; height: 38px; min-width: 38px; border-radius: 10px; background: #edf1ee; border: 1px solid #dce3de; display: flex; align-items: center; justify-content: center;">
                                        <svg style="width: 20px; height: 20px; color: #507159;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 21a9 9 0 100-18 9 9 0 000 18zm0 0v-6m-6-3h6m6 0h-6"/></svg>
                                    </div>
                                    <div style="display: flex; flex-direction: column; min-width: 0;">
                                        <span style="font-size: 13px; font-weight: 800; color: #1e2821; line-height: 1.25;">Racing Sim & VR</span>
                                        <span style="font-size: 11px; font-weight: 500; color: #607267; margin-top: 2px;">Direct Drive & Kokpit</span>
                                    </div>
                                </a>
                            </div>

                        </div>

                        <!-- Clean Minimalist Footer (Sage Green & Putih Abu) -->
                        <div style="margin-top: 18px; padding-top: 14px; border-top: 1px solid #edf1ee; display: flex; align-items: center; justify-content: space-between;">
                            <div style="display: flex; align-items: center; gap: 8px; font-size: 12px; font-weight: 500; color: #607267;">
                                <svg style="width: 16px; height: 16px; color: #507159; shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                <span>Semua produk 100% original & bergaransi resmi distributor Indonesia.</span>
                            </div>
                            <a href="{{ route('products.index') }}" 
                               style="display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 800; color: #ffffff; text-decoration: none; padding: 7px 16px; background: #507159; border-radius: 10px; border: 1px solid #507159; transition: all 0.2s;"
                               onmouseover="this.style.background='#3d5744'; this.style.borderColor='#3d5744';" onmouseout="this.style.background='#507159'; this.style.borderColor='#507159';">
                                <span>Buka Katalog Lengkap</span>
                                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>

                    </div>
                </div>

                <!-- Modern Clean Search Bar (Bigger & Clearer) -->
                <div class="flex-1 max-w-3xl xl:max-w-4xl 2xl:max-w-5xl relative" @click.outside="autocompleteOpen = false">
                    <form action="{{ route('products.index') }}" method="GET" class="relative flex items-center">
                        <div class="relative w-full flex items-center">
                            <input type="text"
                                   name="q"
                                   x-model="searchQuery"
                                   @focus="autocompleteOpen = true"
                                   @keydown.escape="autocompleteOpen = false"
                                   autocomplete="off"
                                   autocorrect="off"
                                   autocapitalize="off"
                                   spellcheck="false"
                                   placeholder="Cari laptop gaming RTX, keyboard mechanical, monitor 240Hz, PS5..."
                                   class="w-full pl-6 pr-20 py-3.5 sm:py-4 bg-slate-50 hover:bg-slate-100/70 focus:bg-white text-base sm:text-lg text-slate-900 rounded-2xl border-2 border-slate-200 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition outline-hidden shadow-xs placeholder:text-slate-400 font-medium">
                            
                            <button type="submit"
                                    class="absolute right-2.5 top-2.5 bottom-2.5 px-5 sm:px-6 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl flex items-center justify-center transition shadow-xs cursor-pointer"
                                    title="Cari">
                                <svg class="w-6 h-6 sm:w-7 sm:h-7 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </button>
                        </div>
                    </form>

                    <!-- Autocomplete Suggestions Dropdown -->
                    <div x-show="autocompleteOpen && searchQuery.trim().length > 0" x-cloak
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="absolute top-full left-0 right-0 mt-2 bg-white rounded-2xl shadow-2xl border border-slate-200/90 overflow-hidden py-2 z-50">
                        
                        <!-- Direct Action: Cari Kata Kunci yang Diketik -->
                        <a :href="'{{ route('products.index') }}?q=' + encodeURIComponent(searchQuery.trim())"
                           class="flex items-center justify-between px-5 py-3 text-base font-bold text-emerald-700 bg-emerald-50/70 hover:bg-emerald-100/80 border-b border-emerald-100 transition">
                            <div class="flex items-center gap-3 min-w-0">
                                <span class="w-7 h-7 rounded-lg bg-emerald-600 text-white flex items-center justify-center shrink-0">
                                    <svg style="width: 16px; height: 16px; min-width: 16px; min-height: 16px;" class="shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </span>
                                <span class="truncate">Cari <span class="text-slate-900 underline underline-offset-2" x-text="'&ldquo;' + searchQuery.trim() + '&rdquo;'"></span> di semua produk</span>
                            </div>
                            <span class="text-sm text-emerald-600 font-extrabold uppercase shrink-0 flex items-center gap-1">
                                Enter &rarr;
                            </span>
                        </a>

                        <div class="px-5 pt-3 pb-1 flex items-center justify-between">
                            <span class="text-xs text-slate-400 font-black uppercase tracking-wider">Rekomendasi Produk Populer</span>
                        </div>

                        <!-- Filtered Suggestions List -->
                        <div class="max-h-72 overflow-y-auto divide-y divide-slate-100">
                            <template x-for="item in suggestions.filter(s => s.toLowerCase().includes(searchQuery.toLowerCase())).slice(0, 6)" :key="item">
                                <a :href="'{{ route('products.index') }}?q=' + encodeURIComponent(item)"
                                    class="flex items-center gap-3 px-5 py-3 text-base text-slate-700 hover:bg-slate-50 hover:text-emerald-700 transition font-semibold group">
                                    <svg style="width: 18px; height: 18px; min-width: 18px; min-height: 18px;" class="shrink-0 text-slate-400 group-hover:text-emerald-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                    <span class="truncate" x-text="item"></span>
                                </a>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Actions: Wishlist, Cart & Profile (Bigger & Ergonomic) -->
                <div class="flex items-center gap-3 sm:gap-4 shrink-0">
                    
                    @auth
                        @if(auth()->user()->isAdmin())
                            <!-- Admin Panel Direct Button -->
                            <a href="{{ route('admin.dashboard') }}"
                               class="inline-flex items-center gap-2 px-4 py-3 rounded-2xl bg-purple-50 hover:bg-purple-100 text-purple-700 border border-purple-200 text-sm font-black transition shadow-2xs">
                                <svg class="w-5 h-5 text-purple-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>
                                <span class="hidden sm:inline">Panel Admin</span>
                            </a>
                        @else
                            <!-- Wishlist Icon -->
                            @php
                                $wishlistCount = auth()->user()->wishlists()->count();
                            @endphp
                            <a href="{{ route('wishlist.index') }}"
                               class="relative p-3 text-slate-700 hover:text-rose-500 rounded-2xl hover:bg-slate-100 transition hidden sm:flex items-center justify-center"
                               title="Wishlist Saya">
                                <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                @if($wishlistCount > 0)
                                    <span class="absolute top-1 right-1 w-5 h-5 rounded-full bg-rose-500 text-white text-[11px] font-black flex items-center justify-center shadow-xs">
                                        {{ $wishlistCount > 99 ? '99+' : $wishlistCount }}
                                    </span>
                                @endif
                            </a>

                            <!-- Cart Icon -->
                            @php
                                $cartCount = auth()->user()->cart?->total_count ?? 0;
                            @endphp
                            <a href="{{ route('cart.index') }}"
                               x-data="{ count: {{ $cartCount }} }"
                               @cart-updated.window="count++"
                               class="relative p-3 text-slate-700 hover:text-emerald-600 rounded-2xl hover:bg-slate-100 transition flex items-center justify-center"
                               title="Keranjang Belanja">
                                <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                <span x-show="count > 0"
                                      x-text="count > 99 ? '99+' : count"
                                      class="absolute top-1 right-1 w-5 h-5 rounded-full bg-emerald-500 text-white text-[11px] font-black flex items-center justify-center shadow-xs">
                                    {{ $cartCount > 99 ? '99+' : $cartCount }}
                                </span>
                            </a>
                        @endif

                        <!-- User Profile Dropdown -->
                        <div class="relative" @click.outside="userDropdownOpen = false">
                            <button @click="userDropdownOpen = !userDropdownOpen"
                                    type="button"
                                    class="flex items-center gap-3 p-2 rounded-2xl hover:bg-slate-100 transition focus:outline-hidden">
                                <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-full bg-emerald-100 text-emerald-800 font-black text-base sm:text-lg flex items-center justify-center border-2 border-emerald-400 shadow-xs">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <span class="text-base sm:text-lg font-black text-slate-800 hidden md:block max-w-[140px] truncate">
                                    {{ auth()->user()->name }}
                                </span>
                                <svg class="w-5 h-5 text-slate-400 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                            </button>

                            <!-- Profile Menu -->
                            <div x-show="userDropdownOpen" x-cloak
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 class="absolute right-0 top-full mt-2 w-64 bg-white rounded-2xl shadow-2xl border border-slate-100 py-3 z-50">
                                <div class="px-4 py-2 border-b border-slate-100">
                                    <p class="text-sm font-bold text-slate-900 truncate">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email }}</p>
                                    <div class="mt-1.5">
                                        <span class="inline-block px-2 py-0.5 text-[10px] font-bold rounded-full bg-emerald-100 text-emerald-800 uppercase tracking-wide">
                                            {{ auth()->user()->role->name }}
                                        </span>
                                    </div>
                                </div>

                                <div class="py-1">
                                    <a href="{{ route('customer.profile') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        Profil Saya
                                    </a>
                                    <a href="{{ route('customer.orders.index') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                        Pesanan Saya
                                    </a>
                                    <a href="{{ route('wishlist.index') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                        Wishlist
                                    </a>
                                    <a href="{{ route('customer.addresses.index') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        Daftar Alamat
                                    </a>
                                </div>

                                @if(auth()->user()->isAdmin())
                                    <div class="py-1 border-t border-slate-100">
                                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs text-purple-700 font-bold hover:bg-purple-50">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                            Dashboard Admin
                                        </a>
                                    </div>
                                @endif

                                <div class="pt-1 border-t border-slate-100">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2 text-xs text-rose-600 hover:bg-rose-50 font-semibold transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                            Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Guest Auth Buttons (Bigger) -->
                        <div class="flex items-center gap-3">
                            <a href="{{ route('login') }}"
                               class="px-5 sm:px-6 py-3 sm:py-3.5 text-base sm:text-lg font-bold text-emerald-600 hover:text-emerald-700 hover:bg-emerald-50 rounded-2xl border-2 border-emerald-500 transition">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}"
                                class="px-5 sm:px-6 py-3 sm:py-3.5 text-base sm:text-lg font-bold text-white bg-emerald-500 hover:bg-emerald-600 rounded-2xl shadow-xs transition hidden sm:inline-block">
                                Daftar
                            </a>
                        </div>
                    @endauth

                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Navigation Drawer -->
    <div x-show="mobileMenuOpen" x-cloak class="relative z-50 md:hidden" role="dialog" aria-modal="true">
        <div x-show="mobileMenuOpen"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs"
             @click="mobileMenuOpen = false"></div>

        <div class="fixed inset-0 flex">
            <div x-show="mobileMenuOpen"
                 x-transition:enter="transition ease-in-out duration-300 transform"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in-out duration-300 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full"
                 class="relative mr-14 flex w-full max-w-sm flex-1">
                
                <div class="flex flex-col overflow-y-auto bg-white px-5 pb-6 pt-5 shadow-2xl w-full">
                    <!-- Drawer Header -->
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                            <div class="w-10 h-10 rounded-2xl bg-emerald-600 flex items-center justify-center text-white shadow-md group-hover:scale-105 transition-transform shrink-0">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-black text-xl tracking-tight text-slate-900 leading-none">SetUp<span class="text-emerald-600">Pedia</span></span>
                                <span class="text-[10px] text-slate-400 font-extrabold tracking-wider uppercase mt-0.5">Gaming & Tech Setup</span>
                            </div>
                        </a>
                        <button @click="mobileMenuOpen = false" class="p-2 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-xl transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <!-- Quick Highlights -->
                    <div class="py-3 border-b border-slate-100">
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <a href="{{ route('products.index', ['filter' => 'flash_sale']) }}" class="flex items-center gap-2 p-2 rounded-xl bg-rose-50 text-rose-700 font-bold border border-rose-100">
                                <span class="w-7 h-7 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/></svg>
                                </span>
                                <div class="truncate">
                                    <p class="text-[11px] leading-tight font-black">Flash Sale</p>
                                    <p class="text-[9px] text-rose-500 font-semibold">Diskon s/d 70%</p>
                                </div>
                            </a>
                            <a href="{{ route('products.index', ['category' => 'pc-rakitan']) }}" class="flex items-center gap-2 p-2 rounded-xl bg-emerald-50 text-emerald-800 font-bold border border-emerald-100">
                                <span class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </span>
                                <div class="truncate">
                                    <p class="text-[11px] leading-tight font-black">Rakit PC</p>
                                    <p class="text-[9px] text-emerald-600 font-semibold">Gratis Rakit</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Primary Mobile Navigation Menus (Besar & Jelas) -->
                    <div class="py-3 space-y-1 border-b border-slate-100">
                        <a href="{{ route('home') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-black {{ request()->routeIs('home') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-800 hover:bg-slate-50' }}">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            <span>Beranda</span>
                        </a>
                        <a href="{{ route('products.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-black {{ request()->routeIs('products.*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-800 hover:bg-slate-50' }}">
                            <span class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                <span>Semua Produk</span>
                            </span>
                            <span class="text-[10px] px-2 py-0.5 bg-emerald-100 text-emerald-800 rounded-full font-bold">Katalog</span>
                        </a>
                        @auth
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-black text-purple-700 bg-purple-50 hover:bg-purple-100">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>
                                    <span>Panel Admin</span>
                                </a>
                            @else
                                <a href="{{ route('customer.orders.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-black {{ request()->routeIs('customer.orders.*') || request()->routeIs('orders.*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-800 hover:bg-slate-50' }}">
                                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                    <span>Pesanan Saya</span>
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-black text-slate-800 hover:bg-slate-50">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                <span>Pesanan Saya</span>
                            </a>
                        @endauth
                    </div>

                    <!-- Category List -->
                    <div class="py-4 space-y-1 border-b border-slate-100">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-wider mb-2">Kategori Produk</p>
                        <a href="{{ route('products.index', ['category' => 'laptop-gaming']) }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50">
                            <span class="w-6 h-6 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </span>
                            <span>Laptop Gaming RTX Series</span>
                        </a>
                        <a href="{{ route('products.index', ['category' => 'pc-rakitan']) }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50">
                            <span class="w-6 h-6 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 4h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V5a1 1 0 011-1zm3 4h.01M8 12h.01M16 8h.01M16 12h.01M8 16h8"/></svg>
                            </span>
                            <span>PC Rakitan Gaming Ready</span>
                        </a>
                        <a href="{{ route('products.index', ['category' => 'pc-komponen']) }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50">
                            <span class="w-6 h-6 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 3v2m6-2v2M9 19v2m6-2v2M3 9h2m-2 6h2m14-6h2m-2 6h2M7 5h10a2 2 0 012 2v10a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2zm2 4h6v6H9V9z"/></svg>
                            </span>
                            <span>Komponen PC & Hardware</span>
                        </a>
                        <a href="{{ route('products.index', ['category' => 'ram-ssd-storage']) }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50">
                            <span class="w-6 h-6 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </span>
                            <span>RAM DDR5 & SSD NVMe</span>
                        </a>
                        <a href="{{ route('products.index', ['category' => 'cooling-power-supply']) }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50">
                            <span class="w-6 h-6 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M12 8a4 4 0 100 8 4 4 0 000-8z"/></svg>
                            </span>
                            <span>Cooler AIO & Power Supply</span>
                        </a>
                        <a href="{{ route('products.index', ['category' => 'keyboard-mechanical']) }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50">
                            <span class="w-6 h-6 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2zm3 4h.01M10 10h.01M14 10h.01M17 10h.01M7 14h10"/></svg>
                            </span>
                            <span>Keyboard Mechanical & Switch</span>
                        </a>
                        <a href="{{ route('products.index', ['category' => 'mouse-gaming']) }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50">
                            <span class="w-6 h-6 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3a6 6 0 00-6 6v6a6 6 0 0012 0V9a6 6 0 00-6-6zm0 0v5"/></svg>
                            </span>
                            <span>Mouse Gaming Ultralight</span>
                        </a>
                        <a href="{{ route('products.index', ['category' => 'audio-headset']) }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50">
                            <span class="w-6 h-6 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 18v-6a9 9 0 0118 0v6M3 18a3 3 0 003 3h1a2 2 0 002-2v-4a2 2 0 00-2-2H4a1 1 0 00-1 1v4zm18 0a3 3 0 01-3 3h-1a2 2 0 01-2-2v-4a2 2 0 012-2h3a1 1 0 011 1v4z"/></svg>
                            </span>
                            <span>Headset 7.1, IEM & DAC</span>
                        </a>
                        <a href="{{ route('products.index', ['category' => 'monitor-gaming']) }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50">
                            <span class="w-6 h-6 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 5h18a2 2 0 012 2v8a2 2 0 01-2 2H3a2 2 0 01-2-2V7a2 2 0 012-2z"/></svg>
                            </span>
                            <span>Monitor Gaming 240Hz OLED</span>
                        </a>
                        <a href="{{ route('products.index', ['category' => 'konsol-handheld']) }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50">
                            <span class="w-6 h-6 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 10h.01M17 12h.01M7 10h4M9 8v4M6.5 19l1.8-6.3A3 3 0 0111.2 10h1.6a3 3 0 012.9 2.7L17.5 19a2 2 0 01-3.4 1.4l-1.3-1.4h-1.6l-1.3 1.4A2 2 0 016.5 19z"/></svg>
                            </span>
                            <span>PlayStation 5 & Handheld</span>
                        </a>
                        <a href="{{ route('products.index', ['category' => 'smartphone-gaming']) }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50">
                            <span class="w-6 h-6 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 18h.01M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z"/></svg>
                            </span>
                            <span>Smartphone Gaming</span>
                        </a>
                        <a href="{{ route('products.index', ['category' => 'streaming-gear']) }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50">
                            <span class="w-6 h-6 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            </span>
                            <span>Streaming Gear & Capture</span>
                        </a>
                        <a href="{{ route('products.index', ['category' => 'racing-sim-vr']) }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50">
                            <span class="w-6 h-6 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke-width="1.8"/><circle cx="12" cy="12" r="3" stroke-width="1.8"/><path stroke-linecap="round" stroke-width="1.8" d="M12 3v6m0 6v6M3 12h6m6 0h6"/></svg>
                            </span>
                            <span>Racing Simulator & VR</span>
                        </a>
                        <a href="{{ route('products.index', ['category' => 'kursi-setup-meja']) }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50">
                            <span class="w-6 h-6 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 3v10a4 4 0 004 4h6a4 4 0 004-4V3M12 17v4m-4 0h8M9 7h6"/></svg>
                            </span>
                            <span>Kursi Gaming & Standing Desk</span>
                        </a>
                        <a href="{{ route('products.index', ['category' => 'aksesoris-gaming']) }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50">
                            <span class="w-6 h-6 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>
                            </span>
                            <span>Aksesoris & Modding Gear</span>
                        </a>
                    </div>

                    <!-- Services & Guarantees -->
                    <div class="py-3 border-b border-slate-100 text-xs space-y-2">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-wider mb-2">Layanan & Jaminan</p>
                        <div class="flex items-center gap-2 text-slate-600">
                            <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>100% Produk Original & Bergaransi</span>
                        </div>
                        <div class="flex items-center gap-2 text-slate-600">
                            <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            <span>Gratis Packing Kayu & Bubble Wrap</span>
                        </div>
                        <div class="flex items-center gap-2 text-slate-600">
                            <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Cicilan 0% & Bayar Instan QRIS</span>
                        </div>
                    </div>

                    <!-- Bottom Info & Promo -->
                    <div class="mt-auto pt-4 space-y-3 text-xs">
                        <div class="p-3 bg-gradient-to-r from-emerald-50 via-teal-50 to-emerald-50 rounded-2xl border border-emerald-200/80 shadow-2xs">
                            <p class="font-bold text-emerald-950 mb-0.5 flex items-center gap-1.5">
                                <span>🎟️</span> Voucher Diskon Gamers
                            </p>
                            <p class="text-[11px] text-emerald-800 font-mono font-bold">KODE: GAMERSEJATI (-Rp 150.000)</p>
                        </div>
                        @guest
                            <div class="grid grid-cols-2 gap-2">
                                <a href="{{ route('login') }}" class="py-2.5 text-center bg-slate-100 hover:bg-slate-200 font-bold rounded-xl text-slate-800 transition">Masuk</a>
                                <a href="{{ route('register') }}" class="py-2.5 text-center bg-emerald-600 hover:bg-emerald-700 font-bold text-white rounded-xl shadow-xs transition">Daftar</a>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Slot -->
    <main class="flex-1 max-w-[1720px] w-full mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 py-6 sm:py-8">
        @yield('content')
    </main>

    <!-- Dedicated Footer Style to guarantee 100% visibility & solid background with Hijau Sage & Putih Abu -->
    <style>
        .footer-custom-green {
            background-color: #384e40 !important;
            color: #eef3ef !important;
        }
        .footer-custom-green .footer-title {
            color: #ffffff !important;
            font-weight: 800 !important;
            letter-spacing: 0.05em !important;
        }
        .footer-custom-green a {
            color: #dce5df !important;
            transition: color 0.15s ease-in-out;
        }
        .footer-custom-green a:hover {
            color: #ffffff !important;
            text-decoration: underline;
        }
        .footer-custom-green .footer-desc {
            color: #c5d3ca !important;
        }
        .footer-custom-green .footer-icon {
            color: #a4c7ad !important;
        }
        .footer-custom-green .footer-social-btn {
            background-color: rgba(255, 255, 255, 0.12) !important;
            color: #ffffff !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.5rem;
            width: 2.25rem;
            height: 2.25rem;
            transition: all 0.15s ease;
        }
        .footer-custom-green .footer-social-btn:hover {
            background-color: #507159 !important;
            color: #ffffff !important;
        }
        .footer-custom-green .footer-divider {
            border-color: rgba(255, 255, 255, 0.15) !important;
        }
        .footer-custom-green .footer-badge {
            background-color: rgba(255, 255, 255, 0.12) !important;
            color: #ffffff !important;
            border: 1px solid rgba(255, 255, 255, 0.18) !important;
        }
    </style>

    <!-- Modern SetUp Pedia Sage Green & Putih Abu Footer -->
    <footer class="footer-custom-green mt-20 pt-12 pb-8 text-xs" style="background-color: #384e40 !important; color: #eef3ef !important;">
        <div class="max-w-[1720px] w-full mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-10 pb-10 footer-divider border-b">
                
                <!-- Col 1: Brand & About (lg:col-span-4) -->
                <div class="lg:col-span-4 space-y-4">
                    <a href="{{ route('home') }}" class="flex items-center gap-3.5 group inline-flex">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-600 flex items-center justify-center text-white shadow-md group-hover:scale-105 transition-transform shrink-0" style="background-color: #507159 !important;">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-black text-2xl sm:text-3xl tracking-tight leading-none text-white">
                                SetUp<span style="color: #a4c7ad;">Pedia</span>
                            </span>
                            <span class="text-[11px] font-extrabold tracking-wider uppercase mt-1" style="color: #c5d3ca;">GAMING & TECH SETUP</span>
                        </div>
                    </a>

                    <p class="text-xs footer-desc leading-relaxed max-w-sm">
                        SetUp Pedia adalah toko online perlengkapan komputer, komponen PC, dan room setup terlengkap untuk pro player, creator, dan antusias tech. Produk original, harga terbaik, dan pengiriman cepat ke seluruh Indonesia.
                    </p>
                </div>

                <!-- Col 2: Kategori (lg:col-span-2) -->
                <div class="lg:col-span-2 space-y-3">
                    <h3 class="text-xs uppercase footer-title">KATEGORI</h3>
                    <ul class="space-y-2.5 text-xs">
                        <li><a href="{{ route('products.index', ['category' => 'komponen-pc']) }}">Komponen PC & Hardware</a></li>
                        <li><a href="{{ route('products.index', ['category' => 'laptop-gaming']) }}">Laptop & Komputer</a></li>
                        <li><a href="{{ route('products.index', ['category' => 'keyboard-mechanical']) }}">Keyboard Mechanical</a></li>
                        <li><a href="{{ route('products.index', ['category' => 'mouse-gaming']) }}">Mouse Gaming</a></li>
                        <li><a href="{{ route('products.index', ['category' => 'monitor-gaming']) }}">Monitor Fast IPS & OLED</a></li>
                        <li><a href="{{ route('products.index', ['category' => 'audio-headset']) }}">Audio & Headset</a></li>
                        <li class="pt-1"><a href="{{ route('products.index') }}" class="font-extrabold text-white underline" style="color: #ffffff !important;">Lihat Semua</a></li>
                    </ul>
                </div>

                <!-- Col 3: Bantuan (lg:col-span-2) -->
                <div class="lg:col-span-2 space-y-3">
                    <h3 class="text-xs uppercase footer-title">BANTUAN</h3>
                    <ul class="space-y-2.5 text-xs">
                        <li><a href="{{ route('home') }}">Tentang Kami</a></li>
                        <li><a href="#">Kontak</a></li>
                        <li><a href="{{ route('customer.orders.index') }}">Lacak Pesanan</a></li>
                        <li><a href="{{ route('products.index', ['sale' => 1]) }}">Promo & Diskon</a></li>
                        <li><a href="{{ route('customer.profile') }}">Akun Saya</a></li>
                        @if(auth()->check() && auth()->user()->isAdmin())
                            <li><a href="{{ route('admin.dashboard') }}" style="color: #6ee7b7 !important; font-weight: bold;">Admin Panel</a></li>
                        @endif
                    </ul>
                </div>

                <!-- Col 4: Hubungi Kami (lg:col-span-4) -->
                <div class="lg:col-span-4 space-y-3">
                    <h3 class="text-xs uppercase footer-title">HUBUNGI KAMI</h3>
                    <div class="space-y-3.5 text-xs">
                        <div class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 footer-icon shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span class="leading-relaxed footer-desc">Jl. W.R. Supratman, Kandang Limun, Kec. Muara Bangka Hulu, Kota Bengkulu</span>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 footer-icon shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <div>
                                <div class="font-bold text-white" style="color: #ffffff;">0800-1-SETUPPEDIA</div>
                                <div class="footer-desc">0812-3456-7890</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 footer-icon shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span class="text-white font-medium" style="color: #ffffff;">cs@setuppedia.id</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 footer-icon shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="footer-desc">Senin - Minggu, 08.00 - 21.00 WIB</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright & Payment Methods -->
            <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left text-[11px] footer-desc">
                <p>&copy; {{ date('Y') }} <strong class="text-white font-bold" style="color: #ffffff;">SetUp Pedia</strong>. Seluruh hak cipta dilindungi.</p>
                <div class="flex flex-wrap items-center justify-center sm:justify-end gap-1.5 sm:gap-2 text-[10px]">
                    <span class="text-slate-300 mr-1 font-semibold">Pembayaran:</span>
                    <span class="px-2.5 py-0.5 rounded footer-badge">Midtrans</span>
                    <span class="px-2.5 py-0.5 rounded footer-badge">QRIS</span>
                    <span class="px-2.5 py-0.5 rounded footer-badge">Virtual Account</span>
                    <span class="px-2.5 py-0.5 rounded footer-badge">GoPay</span>
                    <span class="px-2.5 py-0.5 rounded footer-badge">COD</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile Bottom Navigation Bar -->
    <nav class="fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-md border-t border-slate-200/80 md:hidden flex items-center justify-around py-2 px-1 shadow-lg">
        <a href="{{ route('home') }}" class="flex flex-col items-center gap-0.5 text-[11px] {{ request()->routeIs('home') ? 'text-emerald-600 font-bold' : 'text-slate-500' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <span>Home</span>
        </a>
        <a href="{{ route('products.index') }}" class="flex flex-col items-center gap-0.5 text-[11px] {{ request()->routeIs('products.*') ? 'text-emerald-600 font-bold' : 'text-slate-500' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
            <span>Katalog</span>
        </a>
        @if(auth()->check() && auth()->user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center gap-0.5 text-[11px] text-purple-700 font-bold">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>
                <span>Admin</span>
            </a>
        @else
            <a href="{{ route('cart.index') }}" class="relative flex flex-col items-center gap-0.5 text-[11px] {{ request()->routeIs('cart.*') ? 'text-emerald-600 font-bold' : 'text-slate-500' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                <span>Keranjang</span>
                @auth
                    @if(($cartCount ?? 0) > 0)
                        <span class="absolute -top-1 right-3 w-4 h-4 bg-emerald-600 text-white rounded-full text-[9px] font-bold flex items-center justify-center shadow-xs">
                            {{ $cartCount > 99 ? '99+' : $cartCount }}
                        </span>
                    @endif
                @endauth
            </a>
        @endif
        <a href="{{ auth()->check() ? route('customer.orders.index') : route('login') }}" class="flex flex-col items-center gap-0.5 text-[11px] {{ request()->routeIs('customer.orders.*') ? 'text-emerald-600 font-bold' : 'text-slate-500' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            <span>Pesanan</span>
        </a>
        <a href="{{ auth()->check() ? route('customer.profile') : route('login') }}" class="flex flex-col items-center gap-0.5 text-[11px] {{ request()->routeIs('customer.profile*') ? 'text-emerald-600 font-bold' : 'text-slate-500' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            <span>Akun</span>
        </a>
    </nav>

    <!-- Global Toast Component -->
    <x-toast />

    @stack('scripts')
</body>
</html>
