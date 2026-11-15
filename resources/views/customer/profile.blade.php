@extends('layouts.app')

@section('title', 'Profil Akun Saya')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-200 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight">Informasi Profil Akun</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">Kelola data dasar akun pelanggan, nomor telepon, dan keamanan password Anda.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-xs font-black">
                Pelanggan Terverifikasi
            </span>
        </div>
    </div>

    <!-- Profile Form -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-200 shadow-xs">
        <form action="{{ route('customer.profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Data Pribadi -->
            <div class="space-y-4">
                <h2 class="text-sm font-black text-gray-900 uppercase tracking-wider pb-2 border-b border-gray-100">
                    Data Pribadi
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Nama Lengkap -->
                    <div>
                        <label for="name" class="block text-xs font-bold text-gray-700 mb-1.5">Nama Lengkap <span class="text-rose-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 bg-gray-50 text-xs sm:text-sm text-gray-900 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/15">
                        @error('name') <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-xs font-bold text-gray-700 mb-1.5">Alamat Email <span class="text-rose-500">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 bg-gray-50 text-xs sm:text-sm text-gray-900 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/15">
                        @error('email') <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Nomor Telepon / WA -->
                <div>
                    <label for="phone" class="block text-xs font-bold text-gray-700 mb-1.5">Nomor Handphone / WhatsApp</label>
                    <input type="tel" id="phone" name="phone" inputmode="numeric" pattern="[0-9]*" maxlength="15" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 081234567890"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 bg-gray-50 text-xs sm:text-sm text-gray-900 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/15">
                    @error('phone') <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Ganti Password -->
            <div class="space-y-4 pt-4 border-t border-gray-100" x-data="{ showNewPass: false, showConfirmPass: false }">
                <h2 class="text-sm font-black text-gray-900 uppercase tracking-wider pb-2 border-b border-gray-100">
                    Keamanan Password (Opsional)
                </h2>
                <p class="text-xs text-gray-500">Kosongkan kolom password di bawah jika Anda tidak ingin mengubah password saat ini.</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="new_password" class="block text-xs font-bold text-gray-700 mb-1.5">Password Baru</label>
                        <div class="relative">
                            <input :type="showNewPass ? 'text' : 'password'" type="password" id="new_password" name="new_password" placeholder="Minimal 8 karakter"
                                   class="w-full pl-3.5 pr-10 py-2.5 rounded-xl border border-gray-300 bg-gray-50 text-xs sm:text-sm text-gray-900 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/15">
                            <button type="button" @click="showNewPass = !showNewPass"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-700 focus:outline-hidden transition cursor-pointer"
                                    title="Tampilkan / Sembunyikan Password" tabindex="-1">
                                <svg x-show="showNewPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="!showNewPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                                </svg>
                            </button>
                        </div>
                        @error('new_password') <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="new_password_confirmation" class="block text-xs font-bold text-gray-700 mb-1.5">Konfirmasi Password Baru</label>
                        <div class="relative">
                            <input :type="showConfirmPass ? 'text' : 'password'" type="password" id="new_password_confirmation" name="new_password_confirmation" placeholder="Ulangi password baru"
                                   class="w-full pl-3.5 pr-10 py-2.5 rounded-xl border border-gray-300 bg-gray-50 text-xs sm:text-sm text-gray-900 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/15">
                            <button type="button" @click="showConfirmPass = !showConfirmPass"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-700 focus:outline-hidden transition cursor-pointer"
                                    title="Tampilkan / Sembunyikan Password" tabindex="-1">
                                <svg x-show="showConfirmPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="!showConfirmPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Simpan -->
            <div class="pt-4 flex items-center justify-between border-t border-gray-100">
                <a href="{{ route('customer.addresses.index') }}" class="text-xs font-bold text-emerald-600 hover:underline">
                    &larr; Kelola Buku Alamat Pengiriman
                </a>
                <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Simpan Perubahan Profil</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
