@extends('layouts.app')

@section('title', 'Catat Aktivitas')

@section('content')
@include('components.user.dashboard.dashboard-nav')

<main class="min-h-screen bg-slate-50 py-8 px-4">
    <div class="max-w-lg mx-auto fade-in">

        {{-- Page Header --}}
        <div class="mb-6">
            <a href="{{ route('emission.dashboard') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 transition mb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Dashboard
            </a>
            <h1 class="text-2xl font-extrabold text-gray-900">Catat Jejak Karbon</h1>
            <p class="text-gray-500 text-sm mt-1">Pilih jenis aktivitas dan masukkan jumlahnya.</p>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            {{-- Card Header --}}
            <div class="bg-gradient-to-r from-green-600 to-emerald-500 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="font-bold text-white text-lg">Input Aktivitas Baru</h2>
                        <p class="text-white/70 text-xs">Emisi akan dihitung otomatis</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('emission.store') }}" method="POST" class="p-6 space-y-5" id="emissionForm">
                @csrf

                {{-- Flash messages --}}
                @if(session('success'))
                <div class="p-3.5 bg-green-50 border border-green-200 rounded-xl text-sm text-green-700 flex items-center gap-2">
                    <span>✅</span> {{ session('success') }}
                </div>
                @endif
                @if($errors->any())
                <div class="p-3.5 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
                    ⚠️ {{ $errors->first() }}
                </div>
                @endif

                {{-- Tanggal --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        📅 Tanggal Aktivitas
                    </label>
                    <input type="date" name="entry_date" id="entryDate"
                           value="{{ date('Y-m-d') }}"
                           max="{{ date('Y-m-d') }}"
                           class="input-field" required />
                </div>

                {{-- Pilih Aktivitas --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        🏷️ Jenis Aktivitas
                    </label>
                    <select name="factor_items_id" id="factorSelect"
                            class="input-field" required onchange="updatePreview()">
                        <option value="" disabled selected>-- Pilih jenis aktivitas --</option>
                        @foreach($categories as $category)
                            <optgroup label="━━ {{ $category->category_name }} ━━">
                                @foreach($category->factors as $factor)
                                    <option value="{{ $factor->id }}"
                                            data-value="{{ $factor->value }}"
                                            data-unit="{{ $factor->unit }}">
                                        {{ $factor->name }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>

                {{-- Jumlah Pemakaian --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        📏 Jumlah Pemakaian
                    </label>
                    <div class="flex gap-0">
                        <input type="number" step="0.01" min="0.01" name="quantity" id="quantityInput"
                               class="input-field rounded-r-none flex-1"
                               placeholder="0.00" required oninput="updatePreview()" />
                        <span id="unitLabel"
                              class="inline-flex items-center px-4 bg-gray-100 border border-l-0 border-gray-200 rounded-r-lg text-sm text-gray-500 font-medium whitespace-nowrap">
                            unit
                        </span>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Contoh: Liter (BBM), kWh (Listrik), Kg (Makanan/Gas)</p>
                </div>

                {{-- Emission Preview --}}
                <div id="emissionPreview"
                     class="hidden bg-green-50 border border-green-200 rounded-xl p-4 transition-all">
                    <p class="text-xs font-semibold text-green-600 uppercase mb-1">Estimasi Emisi</p>
                    <div class="flex items-end gap-1">
                        <span id="previewValue" class="text-3xl font-extrabold text-green-700">0</span>
                        <span class="text-sm text-green-600 mb-1 font-medium">kgCO₂ ekuivalen</span>
                    </div>
                    <p class="text-xs text-green-500 mt-1" id="previewFormula">—</p>
                </div>

                {{-- Buttons --}}
                <div class="flex gap-3 pt-2">
                    <a href="{{ route('emission.dashboard') }}" class="btn-outline flex-1 text-center">
                        Batal
                    </a>
                    <button type="submit" class="btn-primary flex-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>

        {{-- Info Panel --}}
        <div class="mt-4 p-4 bg-blue-50 border border-blue-100 rounded-xl text-xs text-blue-600">
            <p class="font-semibold mb-1">💡 Tahukah kamu?</p>
            <p>Rata-rata orang Indonesia menghasilkan sekitar <strong>7.5 ton CO₂</strong> per tahun. Dengan memantau aktivitas harianmu, kamu bisa berkontribusi mengurangi emisi karbon secara nyata.</p>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    function updatePreview() {
        const select = document.getElementById('factorSelect');
        const qty = parseFloat(document.getElementById('quantityInput').value) || 0;
        const selected = select.options[select.selectedIndex];
        const factorVal = parseFloat(selected?.dataset?.value) || 0;
        const unit = selected?.dataset?.unit || 'unit';
        const preview = document.getElementById('emissionPreview');
        const previewValue = document.getElementById('previewValue');
        const previewFormula = document.getElementById('previewFormula');
        const unitLabel = document.getElementById('unitLabel');

        unitLabel.textContent = unit;

        if (factorVal > 0 && qty > 0) {
            const total = (qty * factorVal).toFixed(3);
            previewValue.textContent = total;
            previewFormula.textContent = `${qty} ${unit} × ${factorVal} kgCO₂/${unit} = ${total} kgCO₂`;
            preview.classList.remove('hidden');
        } else {
            preview.classList.add('hidden');
        }
    }
    document.getElementById('factorSelect').addEventListener('change', updatePreview);
</script>
@endpush