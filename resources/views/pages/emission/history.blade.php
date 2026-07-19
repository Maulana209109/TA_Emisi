@extends('layouts.app')

@section('title', 'Riwayat Emisi')

@section('content')
@include('components.user.dashboard.dashboard-nav')

<main class="min-h-screen bg-slate-50 py-8 px-4">
    <div class="max-w-5xl mx-auto fade-in">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-extrabold text-gray-900">Riwayat Jejak Karbon</h1>
                <p class="text-gray-500 text-sm mt-1">Semua pencatatan emisi karbonmu.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('emission.create') }}"
                   class="btn-primary text-sm py-2 px-4">
                    + Catat Baru
                </a>
                <a href="{{ route('emission.dashboard') }}"
                   class="btn-outline text-sm py-2 px-4">
                    ← Dashboard
                </a>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            {{-- Table Header --}}
            <div class="bg-gray-50 border-b border-gray-100 px-6 py-3">
                <div class="grid grid-cols-4 gap-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                    <span>Tanggal</span>
                    <span class="col-span-1">Aktivitas</span>
                    <span class="text-right">Jumlah</span>
                    <span class="text-right">Emisi</span>
                </div>
            </div>

            @php
                $categoryIcons = [
                    'Transportasi'        => ['icon' => '🚗', 'color' => 'bg-blue-50 text-blue-600'],
                    'Energi Rumah Tangga' => ['icon' => '⚡', 'color' => 'bg-yellow-50 text-yellow-600'],
                    'Makanan'             => ['icon' => '🍽️', 'color' => 'bg-orange-50 text-orange-600'],
                    'Limbah'              => ['icon' => '🗑️', 'color' => 'bg-gray-100 text-gray-500'],
                ];
            @endphp

            @forelse($entries as $entry)
                @php
                    $catName = optional(optional($entry->emissionFactor)->category)->category_name ?? '';
                    $meta = $categoryIcons[$catName] ?? ['icon' => '📌', 'color' => 'bg-slate-50 text-slate-500'];
                @endphp
                <div class="px-6 py-4 border-b border-gray-50 hover:bg-slate-50/60 transition grid grid-cols-4 gap-4 items-center">
                    {{-- Tanggal --}}
                    <div>
                        <p class="font-semibold text-gray-800 text-sm">{{ $entry->entry_date->format('d M Y') }}</p>
                        <p class="text-xs text-gray-400">{{ $entry->entry_date->format('l') }}</p>
                    </div>

                    {{-- Aktivitas --}}
                    <div class="col-span-1 flex items-center gap-3">
                        <span class="text-xl hidden sm:block">{{ $meta['icon'] }}</span>
                        <div class="min-w-0">
                            <p class="font-semibold text-gray-800 text-sm truncate">{{ optional($entry->emissionFactor)->name ?? '-' }}</p>
                            @if($catName)
                                <span class="inline-block text-xs px-2 py-0.5 rounded-full {{ $meta['color'] }} mt-0.5">{{ $catName }}</span>
                            @endif
                        </div>
                    </div>

                    {{-- Jumlah --}}
                    <div class="text-right">
                        <p class="font-medium text-gray-700 text-sm">{{ $entry->quantity }}</p>
                        <p class="text-xs text-gray-400">{{ optional($entry->emissionFactor)->unit ?? 'unit' }}</p>
                    </div>

                    {{-- Emisi --}}
                    <div class="text-right">
                        <span class="inline-flex items-center gap-1 bg-red-50 text-red-600 font-bold text-sm px-2.5 py-1 rounded-lg">
                            +{{ number_format($entry->emissions, 2) }}
                            <span class="text-xs font-normal text-red-400">kgCO₂</span>
                        </span>
                    </div>
                </div>
            @empty
                <div class="py-16 text-center">
                    <p class="text-5xl mb-3">🌿</p>
                    <p class="font-semibold text-gray-600 text-lg">Belum ada riwayat</p>
                    <p class="text-gray-400 text-sm mt-1">Mulai catat aktivitas pertamamu!</p>
                    <a href="{{ route('emission.create') }}" class="inline-block mt-5 btn-primary text-sm px-6 py-2.5">
                        Catat Sekarang
                    </a>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($entries->hasPages())
        <div class="mt-5 flex justify-center">
            {{ $entries->links() }}
        </div>
        @endif

    </div>
</main>
@endsection