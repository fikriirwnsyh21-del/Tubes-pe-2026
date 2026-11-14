@extends('layouts.auth')

@section('title', 'Masuk Akun')

@section('content')
<div class="w-full max-w-md bg-white rounded-2xl shadow-xl border border-gray-100 p-8 sm:p-10" x-data="{
    showPassword: false,
    fillCredentials(email, pass) {
        $refs.emailInput.value = email;
        $refs.passwordInput.value = pass;
    }
}">
    <div class="text-center mb-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">Selamat Datang!</h1>
        <p class="text-sm text-gray-500 mt-2">Masuk ke akun Anda untuk berbelanja atau mengelola toko sebagai Administrator.</p>
    </div>

    @if (session('status'))
        <div class="mb-4 p-3 rounded-xl bg-emerald-50 text-emerald-800 text-sm border border-emerald-200">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Quick Demo Accounts (Only Pelanggan & Admin) -->
    <div class="mb-6 p-3 bg-gray-50 rounded-xl border border-gray-200 text-xs">
        <p class="font-semibold text-gray-700 mb-2">Akun Demo (Klik untuk mengisi cepat):</p>
        <div class="grid grid-cols-2 gap-2">
            <button type="button" @click="fillCredentials('customer@example.com', 'password')" class="px-3 py-2 bg-white border border-gray-300 rounded-lg text-gray-800 hover:border-emerald-500 hover:text-emerald-600 font-bold transition text-center shadow-2xs">
                Pelanggan
            </button>
            <button type="button" @click="fillCredentials('admin@example.com', 'password')" class="px-3 py-2 bg-white border border-gray-300 rounded-lg text-gray-800 hover:border-emerald-500 hover:text-emerald-600 font-bold transition text-center shadow-2xs">
                Admin
            </button>
        </div>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
            <input id="email" x-ref="emailInput" type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition text-sm bg-white text-gray-900"
                   placeholder="nama@email.com">
        </div>

        <div>
            <div class="flex items-center justify-between mb-1">
                <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
            </div>
            <div class="relative">
                <input id="password" x-ref="passwordInput" :type="showPassword ? 'text' : 'password'" type="password" name="password" required
                       class="w-full pl-4 pr-11 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition text-sm bg-white text-gray-900"
                       placeholder="••••••••">
                <button type="button" @click="showPassword = !showPassword"
                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-700 focus:outline-hidden transition cursor-pointer"
                        title="Tampilkan / Sembunyikan Password"
                        tabindex="-1">
                    <!-- Eye open (when visible) -->
                    <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <!-- Eye slash / closed (when hidden) -->
                    <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                    </svg>
                </button>
            </div>
        </div>

        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="remember" class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 border-gray-300">
                <span class="text-sm text-gray-600">Ingat Saya</span>
            </label>
        </div>

        <button type="submit"
                class="w-full py-3.5 px-4 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl shadow-md hover:shadow-lg transition duration-150 flex items-center justify-center gap-2 text-sm">
            <span>Masuk Sekarang</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
        </button>
    </form>

    <div class="mt-8 text-center text-sm text-gray-500">
        Belum punya akun?
        <a href="{{ route('register') }}" class="font-bold text-emerald-600 hover:text-emerald-700 underline ml-1">
            Daftar Sekarang
        </a>
    </div>
</div>
@endsection
