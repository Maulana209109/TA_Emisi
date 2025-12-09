@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-5xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Riwayat Jejak Karbon</h1>
            <a href="{{ route('emission.dashboard') }}" class="text-gray-500 hover:text-gray-700">← Kembali ke Dashboard</a>
        </div>

        <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-gray-100">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aktivitas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Emisi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($entries as $entry)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $entry->entry_date->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-medium text-gray-900">{{ $entry->emissionFactor->name }}</span>
                            <span class="block text-xs text-gray-500">{{ $entry->emissionFactor->category->category_name ?? 'Umum' }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $entry->quantity }} Unit
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                {{ number_format($entry->emissions, 2) }} kgCO2
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">Tidak ada data riwayat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <!-- Pagination Links -->
            <div class="px-6 py-3 bg-gray-50">
                {{ $entries->links() }}
            </div>
        </div>
    </div>
</div>
@endsection