@extends('layouts.auth')

@section('title', 'Daftar Akun Baru')

@section('content')
<div class="w-full max-w-lg bg-white rounded-2xl shadow-xl border border-gray-100 p-8 sm:p-10" x-data="{
    showPass: false,
    showConfirm: false
}">
    <div class="text-center mb-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">Daftar Akun Pelanggan</h1>
        <p class="text-sm text-gray-500 mt-2">Daftar akun untuk mulai berbelanja di toko kami.</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                   class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition text-sm text-gray-900"
                   placeholder="Contoh: Budi Pratama">
        </div>

        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Alamat Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                   class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition text-sm text-gray-900"
                   placeholder="nama@email.com">
        </div>

        <div>
            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-1">Nomor WhatsApp / HP</label>
            <input id="phone" type="tel" name="phone" inputmode="numeric" pattern="[0-9]*" value="{{ old('phone') }}"
                   oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                   class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition text-sm text-gray-900"
                   placeholder="08123456789"
                   maxlength="15">
            <p class="text-[11px] text-gray-400 mt-1">Hanya boleh angka (contoh: 08123456789)</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                <div class="relative">
                    <input id="password" :type="showPass ? 'text' : 'password'" type="password" name="password" required
                           class="w-full pl-4 pr-10 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition text-sm text-gray-900"
                           placeholder="Minimal 8 karakter">
                    <button type="button" @click="showPass = !showPass"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-700 focus:outline-hidden transition cursor-pointer"
                            title="Tampilkan / Sembunyikan Password" tabindex="-1">
                        <!-- Eye (visible) -->
                        <svg x-show="showPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <!-- Eye slash (hidden) -->
                        <svg x-show="!showPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">Ulangi Password</label>
                <div class="relative">
                    <input id="password_confirmation" :type="showConfirm ? 'text' : 'password'" type="password" name="password_confirmation" required
                           class="w-full pl-4 pr-10 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition text-sm text-gray-900"
                           placeholder="Ketik ulang password">
                    <button type="button" @click="showConfirm = !showConfirm"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-700 focus:outline-hidden transition cursor-pointer"
                            title="Tampilkan / Sembunyikan Password" tabindex="-1">
                        <!-- Eye (visible) -->
                        <svg x-show="showConfirm" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <!-- Eye slash (hidden) -->
                        <svg x-show="!showConfirm" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="pt-4">
            <button type="submit"
                    class="w-full py-3.5 px-4 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl shadow-md hover:shadow-lg transition duration-150 flex items-center justify-center gap-2 text-sm">
                <span>Daftar Akun Pelanggan</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </button>
        </div>
    </form>

    <div class="mt-8 text-center text-sm text-gray-500">
        Sudah memiliki akun?
        <a href="{{ route('login') }}" class="font-bold text-emerald-600 hover:text-emerald-700 underline ml-1">
            Masuk di sini
        </a>
    </div>
</div>
@endsection
