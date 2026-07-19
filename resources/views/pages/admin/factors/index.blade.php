@extends('layouts.admin')

@section('title', 'Faktor Emisi')
@section('page-title', 'Faktor Emisi')
@section('page-subtitle', 'Kelola nilai pengali emisi karbon per kategori')

@section('content')

{{-- ===== Actions + Filter ===== --}}
<div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-5">
    {{-- Filter Kategori --}}
    <form method="GET" class="flex-1">
        <div class="relative max-w-xs">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                <i class="fas fa-filter text-xs"></i>
            </span>
            <select name="category" onchange="this.form.submit()" class="input-field pl-8 pr-4 py-2 text-sm">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->category_name }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    <div class="flex items-center gap-3">
        <span class="text-sm text-gray-500">
            <i class="fas fa-sliders-h mr-1"></i> {{ $factors->total() }} faktor
        </span>
        <button onclick="openModal('addModal')" class="btn-primary">
            <i class="fas fa-plus"></i> Tambah Faktor
        </button>
    </div>
</div>

{{-- ===== Table ===== --}}
<div class="card overflow-hidden fade-in">
    <div class="p-5 border-b border-gray-100">
        <h3 class="font-bold text-gray-800">Daftar Faktor Emisi</h3>
        <p class="text-xs text-gray-400 mt-0.5">Nilai faktor = kgCO₂e per unit aktivitas</p>
    </div>
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Kategori</th>
                    <th>Nama Faktor</th>
                    <th>Nilai Faktor</th>
                    <th>Satuan</th>
                    <th>Dibuat</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $catColorMap = [
                        'Transportasi'        => ['bg' => 'bg-blue-50',   'text' => 'text-blue-700',   'border' => 'border-blue-200'],
                        'Energi Rumah Tangga' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-700', 'border' => 'border-yellow-200'],
                        'Makanan'             => ['bg' => 'bg-orange-50', 'text' => 'text-orange-700', 'border' => 'border-orange-200'],
                        'Limbah'              => ['bg' => 'bg-gray-100',  'text' => 'text-gray-600',   'border' => 'border-gray-300'],
                    ];
                    $defaultColor = ['bg' => 'bg-purple-50', 'text' => 'text-purple-700', 'border' => 'border-purple-200'];
                @endphp

                @forelse($factors as $factor)
                @php
                    $catName = optional($factor->category)->category_name ?? '';
                    $cc = $catColorMap[$catName] ?? $defaultColor;
                    // Extract unit from factor name e.g. "Mobil (Bensin) (Liter)" → "Liter"
                    preg_match('/\(([^)]+)\)\s*$/', $factor->name, $m);
                    $unit = $m[1] ?? 'unit';
                @endphp
                <tr>
                    <td class="text-gray-400 font-medium text-xs">
                        {{ $loop->iteration + ($factors->currentPage() - 1) * $factors->perPage() }}
                    </td>
                    <td>
                        <span class="inline-flex {{ $cc['bg'] }} {{ $cc['text'] }} border {{ $cc['border'] }} text-xs font-semibold px-2.5 py-1 rounded-lg">
                            {{ $catName ?: '—' }}
                        </span>
                    </td>
                    <td>
                        <span class="font-semibold text-gray-800">{{ $factor->name }}</span>
                    </td>
                    <td>
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-green-700 text-sm">{{ number_format($factor->value, 4) }}</span>
                            <span class="text-xs text-gray-400">kgCO₂e</span>
                        </div>
                    </td>
                    <td>
                        <span class="bg-slate-100 text-slate-600 text-xs font-medium px-2 py-0.5 rounded">
                            /{{ $unit }}
                        </span>
                    </td>
                    <td class="text-gray-500 text-xs">{{ $factor->created_at->format('d M Y') }}</td>
                    <td class="text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button onclick="editFactor({{ $factor->id }}, {{ $factor->factor_category_id }}, '{{ addslashes($factor->name) }}', {{ $factor->value }})"
                                    class="btn-edit">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <form action="{{ route('admin.factors.destroy', $factor->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus faktor \'{{ $factor->name }}\'?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-12 text-gray-400">
                        <i class="fas fa-sliders-h text-3xl mb-2 block opacity-30"></i>
                        Belum ada data faktor emisi
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($factors->hasPages())
    <div class="px-5 py-3 border-t border-gray-100">
        {{ $factors->links() }}
    </div>
    @endif
</div>


{{-- ===== MODAL: Tambah Faktor ===== --}}
<div id="addModal" class="modal-overlay">
    <div class="modal-box">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-lg font-bold text-gray-900">Tambah Faktor Emisi Baru</h3>
            <button onclick="closeModal('addModal')" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        <form action="{{ route('admin.factors.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kategori <span class="text-red-400">*</span></label>
                <select name="factor_category_id" required class="input-field">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Faktor <span class="text-red-400">*</span></label>
                <input type="text" name="name" required class="input-field"
                       placeholder="Contoh: Mobil (Bensin) (Liter)">
                <p class="text-xs text-gray-400 mt-1">Format: Nama (Satuan), mis: LPG (Kg)</p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nilai Faktor (kgCO₂e per unit) <span class="text-red-400">*</span></label>
                <div class="relative">
                    <input type="number" step="0.0001" min="0" name="value" required class="input-field pr-24"
                           placeholder="Contoh: 2.31">
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-400 font-medium">kgCO₂e/unit</span>
                </div>
                <p class="text-xs text-gray-400 mt-1">Referensi: IPCC / Kementerian LHK</p>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeModal('addModal')"
                        style="flex:1;padding:0.6rem;border-radius:0.5rem;border:1.5px solid #e2e8f0;font-weight:500;font-size:0.85rem;background:transparent;cursor:pointer;color:#64748b;"
                        onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='transparent'">
                    Batal
                </button>
                <button type="submit" class="btn-primary" style="flex:1;justify-content:center;">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ===== MODAL: Edit Faktor ===== --}}
<div id="editModal" class="modal-overlay">
    <div class="modal-box">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-lg font-bold text-gray-900">Edit Faktor Emisi</h3>
            <button onclick="closeModal('editModal')" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        <form id="editForm" method="POST" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kategori <span class="text-red-400">*</span></label>
                <select name="factor_category_id" id="edit_factor_category_id" required class="input-field">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Faktor <span class="text-red-400">*</span></label>
                <input type="text" name="name" id="edit_name" required class="input-field">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nilai Faktor (kgCO₂e per unit) <span class="text-red-400">*</span></label>
                <div class="relative">
                    <input type="number" step="0.0001" min="0" name="value" id="edit_value" required class="input-field pr-24">
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-400 font-medium">kgCO₂e/unit</span>
                </div>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeModal('editModal')"
                        style="flex:1;padding:0.6rem;border-radius:0.5rem;border:1.5px solid #e2e8f0;font-weight:500;font-size:0.85rem;background:transparent;cursor:pointer;color:#64748b;"
                        onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='transparent'">
                    Batal
                </button>
                <button type="submit" class="btn-primary" style="flex:1;justify-content:center;">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openModal(id) { document.getElementById(id).classList.add('active'); }
    function closeModal(id) { document.getElementById(id).classList.remove('active'); }
    function editFactor(id, categoryId, name, value) {
        document.getElementById('edit_factor_category_id').value = categoryId;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_value').value = value;
        document.getElementById('editForm').action = `/admin/factors/${id}`;
        openModal('editModal');
    }
    document.querySelectorAll('.modal-overlay').forEach(el => {
        el.addEventListener('click', e => { if (e.target === el) el.classList.remove('active'); });
    });
</script>
@endpush