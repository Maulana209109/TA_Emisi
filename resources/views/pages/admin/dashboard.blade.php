@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan data dan aktivitas sistem')

@section('content')

{{-- ===== STAT CARDS ===== --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

    @php
        $stats = [
            ['label' => 'Total Konsumsi', 'value' => number_format($totalEntries), 'sub' => 'Total input user', 'icon' => 'fa-chart-bar', 'color' => '#16a34a', 'bg' => '#f0fdf4'],
            ['label' => 'Total Pengguna', 'value' => number_format($totalUsers), 'sub' => '+' . $newUsersThisMonth . ' bulan ini', 'icon' => 'fa-users', 'color' => '#2563eb', 'bg' => '#eff6ff'],
            ['label' => 'Faktor Emisi', 'value' => number_format($totalFactors), 'sub' => 'Faktor tersedia', 'icon' => 'fa-sliders-h', 'color' => '#d97706', 'bg' => '#fffbeb'],
            ['label' => 'Kategori', 'value' => number_format($totalCategories), 'sub' => 'Total kategori', 'icon' => 'fa-layer-group', 'color' => '#7c3aed', 'bg' => '#f5f3ff'],
        ];
    @endphp

    @foreach($stats as $i => $s)
    <div class="card p-5 fade-in" style="animation-delay: {{ $i * 0.08 }}s">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">{{ $s['label'] }}</p>
                <p class="text-3xl font-extrabold text-gray-800">{{ $s['value'] }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ $s['sub'] }}</p>
            </div>
            <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0" style="background: {{ $s['bg'] }}">
                <i class="fas {{ $s['icon'] }} text-lg" style="color: {{ $s['color'] }}"></i>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- ===== CHARTS ROW ===== --}}
<div class="grid grid-cols-1 xl:grid-cols-3 gap-4 mb-6">

    {{-- Line Chart --}}
    <div class="card p-5 xl:col-span-2 fade-in" style="animation-delay: 0.32s">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="font-bold text-gray-800">Input Konsumsi per Bulan</h3>
                <p class="text-xs text-gray-400 mt-0.5">Tren aktivitas tahun {{ date('Y') }}</p>
            </div>
            <span class="text-xs bg-green-50 text-green-700 font-semibold px-2.5 py-1 rounded-lg">
                {{ date('Y') }}
            </span>
        </div>
        <div style="height: 260px; position: relative;">
            <canvas id="line-chart"></canvas>
        </div>
    </div>

    {{-- Bar Chart --}}
    <div class="card p-5 fade-in" style="animation-delay: 0.4s">
        <div class="mb-4">
            <h3 class="font-bold text-gray-800">Registrasi User Baru</h3>
            <p class="text-xs text-gray-400 mt-0.5">Pertumbuhan tahun {{ date('Y') }}</p>
        </div>
        <div style="height: 260px; position: relative;">
            <canvas id="bar-chart"></canvas>
        </div>
    </div>
</div>

{{-- ===== TABLES ROW ===== --}}
<div class="grid grid-cols-1 xl:grid-cols-3 gap-4">

    {{-- Top Users --}}
    <div class="card overflow-hidden xl:col-span-2 fade-in" style="animation-delay: 0.48s">
        <div class="p-5 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-gray-800">Top 5 Pengguna Aktif</h3>
                <p class="text-xs text-gray-400 mt-0.5">Berdasarkan jumlah input terbanyak</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="text-xs text-green-600 font-semibold hover:text-green-700">Lihat Semua →</a>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pengguna</th>
                    <th>Email</th>
                    <th class="text-right">Total Input</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topUsers as $i => $user)
                <tr>
                    <td class="text-gray-400 font-bold">{{ $i + 1 }}</td>
                    <td>
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                                <span class="text-xs font-bold text-green-700">{{ strtoupper(substr($user->name,0,1)) }}</span>
                            </div>
                            <span class="font-semibold text-gray-800">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="text-gray-500">{{ $user->email }}</td>
                    <td class="text-right">
                        <span class="bg-green-50 text-green-700 font-bold text-xs px-2.5 py-1 rounded-lg">
                            {{ $user->consumption_entries_count }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-gray-400 py-8">Belum ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Category Stats --}}
    <div class="card overflow-hidden fade-in" style="animation-delay: 0.56s">
        <div class="p-5 border-b border-gray-100">
            <h3 class="font-bold text-gray-800">Sebaran Kategori</h3>
            <p class="text-xs text-gray-400 mt-0.5">Jumlah faktor per kategori</p>
        </div>
        <div class="p-5 space-y-4">
            @php
                $catColors = ['#16a34a','#2563eb','#d97706','#7c3aed','#dc2626'];
                $maxCount = $categoriesStats->max('factors_count') ?: 1;
            @endphp
            @forelse($categoriesStats as $idx => $cat)
            <div>
                <div class="flex justify-between items-center mb-1.5">
                    <p class="text-sm font-medium text-gray-700">{{ $cat->category_name }}</p>
                    <span class="text-xs font-bold text-gray-500">{{ $cat->factors_count }} faktor</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2">
                    <div class="h-2 rounded-full transition-all duration-700"
                         style="width: {{ min(($cat->factors_count / $maxCount)*100, 100) }}%; background: {{ $catColors[$idx % 5] }}">
                    </div>
                </div>
            </div>
            @empty
            <p class="text-gray-400 text-sm text-center py-4">Belum ada data kategori</p>
            @endforelse
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script>
    Chart.defaults.global.defaultFontFamily = 'Inter, sans-serif';
    Chart.defaults.global.defaultFontColor  = '#64748b';

    // ─── Line Chart ───
    new Chart(document.getElementById('line-chart').getContext('2d'), {
        type: 'line',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
            datasets: [{
                label: 'Input Konsumsi',
                data: @json($entriesData),
                backgroundColor: 'rgba(22,163,74,0.1)',
                borderColor: '#16a34a',
                borderWidth: 2.5,
                pointBackgroundColor: '#16a34a',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                fill: true,
                tension: 0.4,
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            legend: { display: false },
            scales: {
                xAxes: [{ gridLines: { display: false }, ticks: { fontColor: '#94a3b8', fontSize: 11 } }],
                yAxes: [{ gridLines: { color: '#f1f5f9', drawBorder: false }, ticks: { fontColor: '#94a3b8', fontSize: 11, beginAtZero: true } }]
            },
            tooltips: { backgroundColor: '#1e293b', titleFontColor: '#fff', bodyFontColor: '#cbd5e1', cornerRadius: 8 }
        }
    });

    // ─── Bar Chart ───
    new Chart(document.getElementById('bar-chart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
            datasets: [{
                label: 'User Baru',
                data: @json($usersData),
                backgroundColor: 'rgba(37,99,235,0.15)',
                borderColor: '#2563eb',
                borderWidth: 2,
                borderRadius: 6,
                barThickness: 14,
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            legend: { display: false },
            scales: {
                xAxes: [{ gridLines: { display: false }, ticks: { fontColor: '#94a3b8', fontSize: 11 } }],
                yAxes: [{ gridLines: { color: '#f1f5f9', drawBorder: false }, ticks: { fontColor: '#94a3b8', fontSize: 11, beginAtZero: true } }]
            },
            tooltips: { backgroundColor: '#1e293b', titleFontColor: '#fff', bodyFontColor: '#cbd5e1', cornerRadius: 8 }
        }
    });
</script>
@endpush