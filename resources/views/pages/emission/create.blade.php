@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-6 flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 bg-green-50">
            <h2 class="text-xl font-bold text-green-800">Catat Jejak Karbon</h2>
            <p class="text-sm text-green-600">Pilih aktivitas untuk menghitung emisi.</p>
        </div>
        
        <form action="{{ route('emission.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            
            <!-- Tanggal -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Aktivitas</label>
                <input type="date" name="entry_date" value="{{ date('Y-m-d') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 p-2.5 border">
            </div>

            <!-- Pilih Kategori/Faktor -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Aktivitas</label>
                <select name="factor_items_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 p-2.5 border bg-white">
                    @foreach($categories as $category)
                        <optgroup label="{{ $category->category_name }}">
                            @foreach($category->factors as $factor)
                                <option value="{{ $factor->id }}">
                                    {{ $factor->name }} ({{ $factor->value }} kgCO2/unit)
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>

            <!-- Jumlah -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Pemakaian</label>
                <div class="flex">
                    <input type="number" step="0.01" name="quantity" class="w-full rounded-l-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 p-2.5 border" placeholder="0.00">
                    <span class="inline-flex items-center px-3 rounded-r-lg border border-l-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                        Unit
                    </span>
                </div>
                <p class="text-xs text-gray-400 mt-1">Contoh: Liter (BBM) atau kWh (Listrik)</p>
            </div>

            <!-- Tombol Action -->
            <div class="flex space-x-3 pt-4">
                <a href="{{ route('emission.dashboard') }}" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg text-center hover:bg-gray-50">Batal</a>
                <button type="submit" class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 shadow-lg shadow-green-200">Simpan Data</button>
            </div>
        </form>
    </div>
</div>
@endsection