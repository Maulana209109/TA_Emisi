@extends('layouts.app')

@section('content')
@include('components.user.dashboard.dashboard-nav')
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-4xl mx-auto space-y-6">
        
        <!-- Welcome Card -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Halo, {{ $user->name }}! 👋</h1>
                <p class="text-gray-500">Mari pantau jejak karbonmu hari ini.</p>
            </div>
            <a href="{{ route('emission.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg font-medium transition shadow-lg shadow-green-200">
                + Catat Jejak Baru
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Card Limit Harian -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase">Limit Harian</p>
                        <h3 class="text-3xl font-bold text-gray-800">{{ number_format($user->dailyCarbonLimit, 1) }} <span class="text-sm font-normal text-gray-400">kgCO2</span></h3>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-lg text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    @php
                        $percentage = ($user->dailyCarbonLimit > 0) ? ($todayEmission / $user->dailyCarbonLimit) * 100 : 0;
                        $color = $percentage > 100 ? 'bg-red-500' : 'bg-blue-500';
                    @endphp
                    <div class="{{ $color }} h-2.5 rounded-full" style="width: {{ min($percentage, 100) }}%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-2">Target batas harian kamu.</p>
            </div>

            <!-- Card Emisi Hari Ini -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase">Emisi Hari Ini</p>
                        <h3 class="text-3xl font-bold {{ $todayEmission > $user->dailyCarbonLimit ? 'text-red-600' : 'text-green-600' }}">
                            {{ number_format($todayEmission, 2) }} <span class="text-sm font-normal text-gray-400">kgCO2</span>
                        </h3>
                    </div>
                    <div class="p-3 {{ $todayEmission > $user->dailyCarbonLimit ? 'bg-red-50 text-red-600' : 'bg-green-50 text-green-600' }} rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"></path></svg>
                    </div>
                </div>
                @if($todayEmission > $user->dailyCarbonLimit)
                    <p class="text-xs text-red-500 font-bold mt-2">⚠️ Kamu telah melewati batas harian!</p>
                @else
                    <p class="text-xs text-green-500 mt-2">✨ Bagus! Masih di bawah batas aman.</p>
                @endif
            </div>
        </div>

        <!-- Recent History List -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="font-bold text-gray-800">Aktivitas Terakhir</h2>
                <a href="{{ route('emission.history') }}" class="text-sm text-green-600 hover:text-green-700 font-medium">Lihat Semua &rarr;</a>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($recentEntries as $entry)
                <div class="p-4 flex items-center justify-between hover:bg-gray-50 transition">
                    <div class="flex items-center space-x-4">
                        <div class="bg-gray-100 p-2 rounded-lg text-2xl">
                            <!-- Ikon sederhana berdasarkan kategori (bisa disesuaikan) -->
                            Example: 🚗
                        </div>
                        <div>
                            <p class="font-bold text-gray-800">{{ $entry->emissionFactor->name }}</p>
                            <p class="text-xs text-gray-500">{{ $entry->entry_date->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-red-500">+{{ number_format($entry->emissions, 2) }} kg</p>
                        <p class="text-xs text-gray-400">{{ $entry->quantity }} Unit</p>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-gray-500">Belum ada data aktivitas.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection