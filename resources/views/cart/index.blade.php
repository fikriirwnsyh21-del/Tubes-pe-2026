@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="space-y-6" x-data="{
    selectAll: {{ $cart->items->every(fn($i) => $i->is_selected) ? 'true' : 'false' }},
    subtotal: {{ $cart->subtotal }},
    itemsCount: {{ $cart->total_count }},

    toggleSelectAll() {
        fetch('{{ route('cart.toggle-all') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ is_selected: this.selectAll })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                this.subtotal = data.cartSubtotal;
                window.location.reload();
            }
        });
    },

    toggleItem(itemId, isSelected) {
        fetch('/cart/item/' + itemId + '/toggle', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ is_selected: isSelected })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                this.subtotal = data.cartSubtotal;
            }
        });
    },

    updateQty(itemId, newQty) {
        if (newQty < 1) return;
        fetch('/cart/item/' + itemId, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ quantity: newQty })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                this.subtotal = data.cartSubtotal;
                this.itemsCount = data.totalCount;
                let subtotalEl = document.getElementById('item-subtotal-' + itemId);
                if (subtotalEl) {
                    subtotalEl.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(data.itemSubtotal);
                }
            } else {
                alert(data.message);
            }
        });
    }
}">

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
                <span class="text-slate-900 font-bold">Keranjang Belanja</span>
            </nav>
        </div>

        <a href="{{ route('home') }}" class="text-xs font-bold text-slate-500 hover:text-emerald-600 inline-flex items-center gap-1.5 transition self-start sm:self-auto">
            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <span>Ke Beranda SetUp Pedia</span>
        </a>
    </div>

    <!-- Header Title Banner -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 sm:p-6 rounded-3xl border border-slate-200/90 shadow-2xs">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Keranjang Belanja</h1>
                @if(!$cart->items->isEmpty())
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-xs font-black border border-emerald-200">
                        {{ $cart->total_count }} Produk
                    </span>
                @endif
            </div>
            <p class="text-xs sm:text-sm text-slate-500">Kelola gear dan produk yang ingin Anda beli sekarang atau nanti</p>
        </div>
        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-700 hover:text-emerald-600 hover:bg-slate-50 hover:border-emerald-300 transition shrink-0">
            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            <span>Lanjut Belanja Gear</span>
        </a>
    </div>

    @if($cart->items->isEmpty())
        <!-- Empty State -->
        <div class="bg-white rounded-3xl p-12 text-center border border-gray-200 shadow-xs flex flex-col items-center justify-center my-8">
            <div class="w-24 h-24 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center mb-4">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            </div>
            <h2 class="text-xl font-bold text-gray-900 mb-1">Wah, keranjang belanjaanmu kosong!</h2>
            <p class="text-sm text-gray-500 max-w-sm mb-6">
                Yuk, isi dengan barang-barang impianmu sekarang juga. Ribuan promo diskon menarik menunggu!
            </p>
            <a href="{{ route('products.index') }}"
               class="px-6 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-sm rounded-xl shadow-md transition">
                Mulai Belanja Sekarang
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left: Cart Items List (8 cols) -->
            <div class="lg:col-span-8 space-y-4">
                
                <!-- Select All Bar -->
                <div class="bg-white p-4 sm:p-5 rounded-2xl border border-gray-200 flex items-center justify-between shadow-xs">
                    <label class="flex items-center gap-3 cursor-pointer select-none">
                        <input type="checkbox" x-model="selectAll" @change="toggleSelectAll()"
                               class="w-5 h-5 rounded text-emerald-600 focus:ring-emerald-500 border-gray-300">
                        <span class="text-sm font-bold text-gray-800">Pilih Semua ({{ $cart->items->count() }} Produk)</span>
                    </label>
                </div>

                <!-- Items Grouped by Shop -->
                @foreach($itemsByShop as $shopName => $items)
                    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-xs">
                        <!-- Shop Header -->
                        <div class="bg-gray-50/70 px-5 py-3 border-b border-gray-100 flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/></svg>
                            <span class="font-bold text-xs sm:text-sm text-gray-800">{{ $shopName }}</span>
                            <span class="text-[11px] text-gray-400">• {{ $items->first()->product->shop->city }}</span>
                        </div>

                        <!-- Shop Item Rows -->
                        <div class="divide-y divide-gray-100 p-4 sm:p-5 space-y-4 sm:space-y-0">
                            @foreach($items as $item)
                                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pt-4 first:pt-0"
                                     x-data="{ itemQty: {{ $item->quantity }}, itemSelected: {{ $item->is_selected ? 'true' : 'false' }} }">
                                    
                                    <div class="flex items-start gap-3 flex-1">
                                        <!-- Checkbox -->
                                        <input type="checkbox" x-model="itemSelected"
                                               @change="toggleItem({{ $item->id }}, itemSelected)"
                                               class="w-5 h-5 rounded text-emerald-600 focus:ring-emerald-500 border-gray-300 mt-3 shrink-0">

                                        <!-- Product Image -->
                                        <a href="{{ route('products.show', $item->product->slug) }}"
                                           class="w-20 h-20 rounded-xl overflow-hidden bg-gray-100 shrink-0 border border-gray-100">
                                            <img src="{{ $item->product->thumbnail_url }}" alt="{{ $item->product->name }}"
                                                 onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&auto=format&fit=crop&q=80';"
                                                 class="w-full h-full object-cover">
                                        </a>

                                        <!-- Info -->
                                        <div class="space-y-1">
                                            <a href="{{ route('products.show', $item->product->slug) }}"
                                               class="text-sm font-semibold text-gray-800 hover:text-emerald-600 line-clamp-2 leading-tight">
                                                {{ $item->product->name }}
                                            </a>
                                            @if($item->variant)
                                                <span class="inline-block px-2 py-0.5 bg-gray-100 text-gray-600 text-[11px] font-medium rounded-md">
                                                    Varian: {{ $item->variant->value }}
                                                </span>
                                            @endif
                                            <div class="text-sm font-bold text-gray-900">
                                                Rp {{ number_format($item->unit_price, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Controls: Quantity & Subtotal & Delete -->
                                    <div class="flex sm:flex-col items-center sm:items-end justify-between w-full sm:w-auto gap-3">
                                        <div class="text-right">
                                            <span class="text-xs text-gray-400 hidden sm:block">Subtotal</span>
                                            <span id="item-subtotal-{{ $item->id }}" class="text-sm sm:text-base font-black text-emerald-600">
                                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                            </span>
                                        </div>

                                        <div class="flex items-center gap-2">
                                            <!-- Delete Form -->
                                            <form action="{{ route('cart.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus barang ini dari keranjang?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-gray-400 hover:text-rose-500 transition" title="Hapus">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>

                                            <!-- Quantity Stepper -->
                                            <div class="flex items-center border border-gray-300 rounded-xl overflow-hidden h-8">
                                                <button type="button" @click="if (itemQty > 1) { itemQty--; updateQty({{ $item->id }}, itemQty); }"
                                                        class="w-7 h-full flex items-center justify-center hover:bg-gray-100 text-gray-600 font-bold transition">
                                                    -
                                                </button>
                                                <input type="number" x-model="itemQty"
                                                       @change="updateQty({{ $item->id }}, itemQty)"
                                                       class="w-10 h-full text-center text-xs font-bold border-x border-gray-300 focus:outline-hidden [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                                <button type="button" @click="itemQty++; updateQty({{ $item->id }}, itemQty);"
                                                        class="w-7 h-full flex items-center justify-center hover:bg-gray-100 text-gray-600 font-bold transition">
                                                    +
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

            </div>

            <!-- Right: Order Summary Card (4 cols) -->
            <div class="lg:col-span-4 bg-white p-6 rounded-3xl border border-gray-200 shadow-xs space-y-5 lg:sticky lg:top-24">
                <h3 class="text-base font-black text-gray-900 pb-3 border-b border-gray-100">Ringkasan Belanja</h3>

                <div class="space-y-3 text-sm text-gray-600">
                    <div class="flex items-center justify-between">
                        <span>Total Produk Dipilih:</span>
                        <span class="font-semibold text-gray-900" x-text="itemsCount + ' barang'"></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Total Harga (Produk):</span>
                        <span class="font-bold text-gray-900">
                            Rp <span x-text="new Intl.NumberFormat('id-ID').format(subtotal)"></span>
                        </span>
                    </div>
                    <div class="flex items-center justify-between text-xs text-gray-400">
                        <span>Estimasi Ongkos Kirim:</span>
                        <span>Dihitung saat checkout</span>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                    <span class="text-sm font-bold text-gray-900">Total Pembayaran:</span>
                    <span class="text-xl font-black text-emerald-600">
                        Rp <span x-text="new Intl.NumberFormat('id-ID').format(subtotal)"></span>
                    </span>
                </div>

                <a href="{{ route('checkout.index') }}"
                   class="w-full py-3.5 bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-sm rounded-xl shadow-md hover:shadow-lg transition duration-150 flex items-center justify-center gap-2"
                   :class="subtotal <= 0 ? 'pointer-events-none opacity-50' : ''">
                    <span>Lanjut ke Checkout</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>

        </div>
    @endif

</div>
@endsection
