@extends('layouts.app')

@section('title', 'Daftar Akun')

@section('content')
<div class="min-h-screen flex gradient-hero">

    {{-- ===== LEFT PANEL (Branding) ===== --}}
    <div class="hidden lg:flex flex-col justify-between w-5/12 p-12 text-white">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                </svg>
            </div>
            <span class="text-xl font-bold tracking-tight">Jejak Karbon</span>
        </div>

        <div class="fade-in">
            <h1 class="text-4xl font-extrabold leading-tight mb-5">
                Mulai Perjalanan<br><span class="text-emerald-300">Hidup Hijau</span> Hari Ini.
            </h1>
            <p class="text-white/70 text-lg leading-relaxed mb-10">
                Bergabung dan mulai lacak jejak karbon harianmu untuk masa depan yang lebih berkelanjutan.
            </p>
            <div class="space-y-4">
                @foreach([
                    ['icon' => '🌿', 'text' => 'Gratis untuk semua pengguna'],
                    ['icon' => '🔒', 'text' => 'Data privasimu terlindungi'],
                    ['icon' => '📱', 'text' => 'Mudah digunakan dari perangkat apapun'],
                ] as $feat)
                <div class="flex items-center gap-3 text-white/80">
                    <span class="text-xl">{{ $feat['icon'] }}</span>
                    <span class="text-sm font-medium">{{ $feat['text'] }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <p class="text-white/40 text-xs">© {{ date('Y') }} Jejak Karbon · Sistem Monitoring Emisi Karbon</p>
    </div>

    {{-- ===== RIGHT PANEL (Form) ===== --}}
    <div class="flex-1 flex items-center justify-center p-6 bg-white/5 backdrop-blur-sm">
        <div class="w-full max-w-md slide-up">
            <div class="bg-white rounded-2xl shadow-2xl p-8 border border-white/60">

                {{-- Mobile Logo --}}
                <div class="flex lg:hidden items-center gap-2 mb-6">
                    <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                        </svg>
                    </div>
                    <span class="font-bold text-gray-800">Jejak Karbon</span>
                </div>

                <h2 class="text-2xl font-bold text-gray-900 mb-1">Buat Akun Baru 🌱</h2>
                <p class="text-gray-500 text-sm mb-7">Isi data di bawah ini untuk membuat akun.</p>

                @if($errors->any())
                <div class="mb-4 p-3.5 bg-red-50 border border-red-200 rounded-xl flex gap-3 items-start">
                    <span class="text-red-500 mt-0.5">⚠️</span>
                    <div>
                        <p class="text-red-700 text-sm font-semibold">Registrasi Gagal</p>
                        <p class="text-red-600 text-xs mt-0.5">{{ $errors->first() }}</p>
                    </div>
                </div>
                @endif

                <form action="{{ route('register.submit') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </span>
                            <input class="input-field pl-10 @error('name') border-red-400 @enderror"
                                type="text" name="name" value="{{ old('name') }}"
                                placeholder="Nama lengkap kamu" required autofocus />
                        </div>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </span>
                            <input class="input-field pl-10 @error('email') border-red-400 @enderror"
                                type="email" name="email" value="{{ old('email') }}"
                                placeholder="contoh@email.com" required />
                        </div>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </span>
                            <input id="password" class="input-field pl-10 @error('password') border-red-400 @enderror"
                                type="password" name="password"
                                placeholder="Min. 8 karakter" required />
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </span>
                            <input class="input-field pl-10"
                                type="password" name="password_confirmation"
                                placeholder="Ulangi password" required />
                        </div>
                    </div>

                    <button type="submit" class="btn-primary w-full mt-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                        Buat Akun Sekarang
                    </button>
                </form>

                <p class="mt-6 text-center text-sm text-gray-500">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-semibold text-green-600 hover:text-green-700 transition">Masuk di sini</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection