@extends('layouts.admin')

@section('title', 'Kategori Emisi')
@section('page-title', 'Kategori Emisi')
@section('page-subtitle', 'Kelola kategori sumber emisi karbon')

@section('content')

{{-- ===== Actions ===== --}}
<div class="flex items-center justify-between mb-5">
    <div class="flex items-center gap-2 text-sm text-gray-500">
        <i class="fas fa-layer-group"></i>
        <span>{{ $categories->total() }} kategori tersedia</span>
    </div>
    <button onclick="openModal('addModal')" class="btn-primary">
        <i class="fas fa-plus"></i> Tambah Kategori
    </button>
</div>

{{-- ===== Table ===== --}}
<div class="card overflow-hidden fade-in">
    <div class="p-5 border-b border-gray-100">
        <h3 class="font-bold text-gray-800">Daftar Kategori Emisi</h3>
        <p class="text-xs text-gray-400 mt-0.5">Setiap kategori memiliki beberapa faktor emisi di dalamnya</p>
    </div>
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Kategori</th>
                    <th>Jumlah Faktor</th>
                    <th>Dibuat</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $catIcons = ['🚗','⚡','🍽️','🗑️','🌿','🏭'];
                    $catColors = [
                        ['bg' => 'bg-blue-50',   'text' => 'text-blue-700',   'border' => 'border-blue-200'],
                        ['bg' => 'bg-yellow-50',  'text' => 'text-yellow-700', 'border' => 'border-yellow-200'],
                        ['bg' => 'bg-orange-50',  'text' => 'text-orange-700', 'border' => 'border-orange-200'],
                        ['bg' => 'bg-gray-100',   'text' => 'text-gray-600',   'border' => 'border-gray-200'],
                        ['bg' => 'bg-green-50',   'text' => 'text-green-700',  'border' => 'border-green-200'],
                        ['bg' => 'bg-purple-50',  'text' => 'text-purple-700', 'border' => 'border-purple-200'],
                    ];
                @endphp
                @forelse($categories as $category)
                @php $ci = $loop->index % 6; @endphp
                <tr>
                    <td class="text-gray-400 font-medium text-xs">
                        {{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}
                    </td>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 {{ $catColors[$ci]['bg'] }} rounded-xl flex items-center justify-center text-lg flex-shrink-0">
                                {{ $catIcons[$ci] }}
                            </div>
                            <span class="font-semibold text-gray-800">{{ $category->category_name }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="inline-flex items-center gap-1 {{ $catColors[$ci]['bg'] }} {{ $catColors[$ci]['text'] }} border {{ $catColors[$ci]['border'] }} text-xs font-semibold px-2.5 py-1 rounded-lg">
                            <i class="fas fa-sliders-h text-xs"></i>
                            {{ $category->factors_count }} faktor
                        </span>
                    </td>
                    <td class="text-gray-500 text-xs">{{ $category->created_at->format('d M Y') }}</td>
                    <td class="text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button onclick="editCategory({{ $category->id }}, '{{ addslashes($category->category_name) }}')"
                                    class="btn-edit">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus kategori \'{{ $category->category_name }}\'? Semua faktor di dalamnya juga akan terhapus.')">
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
                    <td colspan="5" class="text-center py-12 text-gray-400">
                        <i class="fas fa-layer-group text-3xl mb-2 block opacity-30"></i>
                        Belum ada data kategori
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($categories->hasPages())
    <div class="px-5 py-3 border-t border-gray-100">
        {{ $categories->links() }}
    </div>
    @endif
</div>


{{-- ===== MODAL: Tambah Kategori ===== --}}
<div id="addModal" class="modal-overlay">
    <div class="modal-box">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-lg font-bold text-gray-900">Tambah Kategori Baru</h3>
            <button onclick="closeModal('addModal')" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Kategori <span class="text-red-400">*</span></label>
                <input type="text" name="category_name" required class="input-field"
                       placeholder="Contoh: Transportasi Udara">
                <p class="text-xs text-gray-400 mt-1">Nama harus unik dan deskriptif</p>
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

{{-- ===== MODAL: Edit Kategori ===== --}}
<div id="editModal" class="modal-overlay">
    <div class="modal-box">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-lg font-bold text-gray-900">Edit Kategori</h3>
            <button onclick="closeModal('editModal')" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        <form id="editForm" method="POST" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Kategori <span class="text-red-400">*</span></label>
                <input type="text" name="category_name" id="edit_category_name" required class="input-field">
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
    function editCategory(id, name) {
        document.getElementById('edit_category_name').value = name;
        document.getElementById('editForm').action = `/admin/categories/${id}`;
        openModal('editModal');
    }
    document.querySelectorAll('.modal-overlay').forEach(el => {
        el.addEventListener('click', e => { if (e.target === el) el.classList.remove('active'); });
    });
</script>
@endpush