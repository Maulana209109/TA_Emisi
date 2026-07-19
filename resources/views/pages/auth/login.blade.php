@extends('layouts.app')

@section('title', 'Masuk')

@section('content')
<div class="min-h-screen flex gradient-hero">

    {{-- ===== LEFT PANEL (Branding) ===== --}}
    <div class="hidden lg:flex flex-col justify-between w-5/12 p-12 text-white">
        {{-- Logo --}}
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                </svg>
            </div>
            <span class="text-xl font-bold tracking-tight">Jejak Karbon</span>
        </div>

        {{-- Headline --}}
        <div class="fade-in">
            <h1 class="text-4xl font-extrabold leading-tight mb-5">
                Pantau <span class="text-emerald-300">Jejak Karbonmu</span><br>Setiap Hari.
            </h1>
            <p class="text-white/70 text-lg leading-relaxed">
                Lacak konsumsi energi, transportasi, dan makananmu dalam satu <br>
                platform yang mudah digunakan.
            </p>

            {{-- Feature highlights --}}
            <div class="mt-10 space-y-4">
                @foreach([
                    ['icon' => '⚡', 'text' => 'Kalkulasi otomatis berbasis standar IPCC'],
                    ['icon' => '📊', 'text' => 'Dashboard visualisasi emisi harian'],
                    ['icon' => '🎯', 'text' => 'Target karbon harian yang personal'],
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

                <h2 class="text-2xl font-bold text-gray-900 mb-1">Selamat Datang 👋</h2>
                <p class="text-gray-500 text-sm mb-7">Masuk untuk memantau jejak karbonmu hari ini.</p>

                {{-- Flash Messages --}}
                @if($errors->any())
                <div class="mb-4 p-3.5 bg-red-50 border border-red-200 rounded-xl flex gap-3 items-start">
                    <span class="text-red-500 mt-0.5">⚠️</span>
                    <div>
                        <p class="text-red-700 text-sm font-semibold">Login Gagal</p>
                        <p class="text-red-600 text-xs mt-0.5">{{ $errors->first() }}</p>
                    </div>
                </div>
                @endif

                @if(session('success'))
                <div class="mb-4 p-3.5 bg-green-50 border border-green-200 rounded-xl flex gap-3 items-start">
                    <span class="text-green-600 mt-0.5">✅</span>
                    <p class="text-green-700 text-sm">{{ session('success') }}</p>
                </div>
                @endif

                {{-- Login Form --}}
                <form action="{{ route('login.submit') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg class="w-4.5 h-4.5 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </span>
                            <input id="email" class="input-field pl-10 @error('email') border-red-400 @enderror"
                                type="email" name="email" value="{{ old('email') }}"
                                placeholder="contoh@email.com" required autocomplete="email" />
                        </div>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-1.5">
                            <label for="password" class="text-sm font-medium text-gray-700">Password</label>
                        </div>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </span>
                            <input id="password" class="input-field pl-10 pr-12 @error('password') border-red-400 @enderror"
                                type="password" name="password" placeholder="••••••••" required />
                            <button type="button" id="togglePass" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition">
                                <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn-primary w-full mt-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        Masuk ke Dashboard
                    </button>
                </form>

                <p class="mt-6 text-center text-sm text-gray-500">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-semibold text-green-600 hover:text-green-700 transition">Daftar di sini</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const toggleBtn = document.getElementById('togglePass');
    const passInput = document.getElementById('password');
    toggleBtn.addEventListener('click', () => {
        const isPass = passInput.type === 'password';
        passInput.type = isPass ? 'text' : 'password';
        toggleBtn.querySelector('svg').style.opacity = isPass ? '0.5' : '1';
    });
</script>
@endpush