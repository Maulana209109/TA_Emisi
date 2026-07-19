@extends('layouts.app')

@section('title', 'Dashboard Emisi')

@section('content')
@include('components.user.dashboard.dashboard-nav')

<main class="min-h-screen bg-slate-50 pb-12">

    {{-- ===== Hero / Greeting Section ===== --}}
    <div class="gradient-hero text-white">
        <div class="max-w-5xl mx-auto px-6 py-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <p class="text-emerald-300 text-sm font-medium mb-1">{{ now()->translatedFormat('l, d F Y') }}</p>
                    <h1 class="text-2xl sm:text-3xl font-extrabold leading-tight">
                        Halo, {{ $user->name }}! 👋
                    </h1>
                    <p class="text-white/70 mt-1 text-sm">Mari pantau dan kurangi jejak karbonmu hari ini.</p>
                </div>
                <a href="{{ route('emission.create') }}"
                   class="inline-flex items-center gap-2 bg-white text-green-700 font-semibold px-5 py-2.5 rounded-xl shadow-lg hover:shadow-xl hover:bg-green-50 transition text-sm self-start sm:self-auto">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    Catat Jejak Baru
                </a>
            </div>

            {{-- Status alert --}}
            @php
                $limitSet = $user->dailyCarbonLimit > 0;
                $percentage = $limitSet ? ($todayEmission / $user->dailyCarbonLimit) * 100 : 0;
                $overLimit = $limitSet && $todayEmission > $user->dailyCarbonLimit;
            @endphp
            @if($limitSet)
            <div class="mt-6 bg-white/10 border border-white/20 rounded-xl p-4 backdrop-blur-sm">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-medium text-white">
                        @if($overLimit)
                            ⚠️ Kamu telah melebihi batas harian!
                        @else
                            ✅ Masih di bawah batas aman hari ini
                        @endif
                    </p>
                    <span class="text-xs font-semibold text-white/80">
                        {{ number_format($todayEmission, 1) }} / {{ number_format($user->dailyCarbonLimit, 1) }} kgCO₂
                    </span>
                </div>
                <div class="w-full bg-white/20 rounded-full h-2">
                    <div class="h-2 rounded-full transition-all duration-700 ease-out {{ $overLimit ? 'bg-red-400' : 'bg-emerald-300' }}"
                         style="width: {{ min($percentage, 100) }}%"></div>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- ===== Stats Cards ===== --}}
    <div class="max-w-5xl mx-auto px-6 -mt-5">

        {{-- Flash Message --}}
        @if(session('success'))
        <div class="mb-4 flex items-center gap-2.5 bg-green-50 border border-green-200 text-green-700 text-sm font-medium px-4 py-3 rounded-xl">
            <span>✅</span> {{ session('success') }}
        </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

            {{-- Card: Emisi Hari Ini --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 fade-in">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Emisi Hari Ini</p>
                        <p class="text-3xl font-extrabold {{ $overLimit ? 'text-red-600' : 'text-green-600' }}">
                            {{ number_format($todayEmission, 2) }}
                        </p>
                        <p class="text-xs text-gray-400 mt-0.5">kgCO₂ ekuivalen</p>
                    </div>
                    <div class="p-2.5 rounded-xl {{ $overLimit ? 'bg-red-50' : 'bg-green-50' }}">
                        <svg class="w-6 h-6 {{ $overLimit ? 'text-red-500' : 'text-green-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Card: Batas Harian --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 fade-in" style="animation-delay:0.1s">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Batas Harian</p>
                        <p class="text-3xl font-extrabold text-blue-600">
                            {{ $limitSet ? number_format($user->dailyCarbonLimit, 1) : '—' }}
                        </p>
                        <p class="text-xs text-gray-400 mt-0.5">kgCO₂ per hari</p>
                    </div>
                    <div class="p-2.5 rounded-xl bg-blue-50">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Card: Sisa Kuota --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 fade-in" style="animation-delay:0.2s">
                <div class="flex items-start justify-between">
                    <div>
                        @php $sisa = max(0, $user->dailyCarbonLimit - $todayEmission); @endphp
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Sisa Kuota</p>
                        <p class="text-3xl font-extrabold {{ $overLimit ? 'text-orange-500' : 'text-slate-700' }}">
                            {{ $limitSet ? number_format($sisa, 1) : '—' }}
                        </p>
                        <p class="text-xs text-gray-400 mt-0.5">kgCO₂ tersisa hari ini</p>
                    </div>
                    <div class="p-2.5 rounded-xl {{ $overLimit ? 'bg-orange-50' : 'bg-slate-50' }}">
                        <svg class="w-6 h-6 {{ $overLimit ? 'text-orange-500' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== Recent Activity ===== --}}
    <div class="max-w-5xl mx-auto px-6 mt-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden fade-in" style="animation-delay:0.3s">
            <div class="flex items-center justify-between p-5 border-b border-gray-100">
                <div>
                    <h2 class="font-bold text-gray-800">Aktivitas Terakhir</h2>
                    <p class="text-xs text-gray-400 mt-0.5">5 pencatatan terbaru</p>
                </div>
                <a href="{{ route('emission.history') }}"
                   class="text-sm font-semibold text-green-600 hover:text-green-700 flex items-center gap-1 transition">
                    Lihat Semua
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            @php
                $categoryIcons = [
                    'Transportasi'       => ['icon' => '🚗', 'color' => 'bg-blue-50'],
                    'Energi Rumah Tangga'=> ['icon' => '⚡', 'color' => 'bg-yellow-50'],
                    'Makanan'            => ['icon' => '🍽️', 'color' => 'bg-orange-50'],
                    'Limbah'             => ['icon' => '🗑️', 'color' => 'bg-gray-100'],
                ];
            @endphp

            <div class="divide-y divide-gray-50">
                @forelse($recentEntries as $entry)
                    @php
                        $catName = optional(optional($entry->emissionFactor)->category)->category_name ?? '';
                        $meta = $categoryIcons[$catName] ?? ['icon' => '📌', 'color' => 'bg-slate-50'];
                    @endphp
                    <div class="flex items-center justify-between p-4 hover:bg-slate-50/70 transition">
                        <div class="flex items-center gap-4">
                            <div class="w-11 h-11 {{ $meta['color'] }} rounded-xl flex items-center justify-center text-2xl flex-shrink-0">
                                {{ $meta['icon'] }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm leading-tight">{{ optional($entry->emissionFactor)->name ?? '-' }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $entry->entry_date->format('d M Y') }} · {{ $entry->quantity }} unit</p>
                            </div>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <p class="font-bold text-red-500 text-sm">+{{ number_format($entry->emissions, 2) }}</p>
                            <p class="text-xs text-gray-400">kgCO₂</p>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center">
                        <p class="text-4xl mb-3">🌿</p>
                        <p class="font-semibold text-gray-600">Belum ada data aktivitas</p>
                        <p class="text-sm text-gray-400 mt-1">Mulai catat aktivitasmu sekarang!</p>
                        <a href="{{ route('emission.create') }}" class="inline-block mt-4 btn-primary text-sm px-5 py-2">
                            Catat Pertama Kali
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</main>
@endsection