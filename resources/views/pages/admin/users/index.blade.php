@extends('layouts.admin')

@section('title', 'Manajemen Pengguna')
@section('page-title', 'Manajemen Pengguna')
@section('page-subtitle', 'Kelola akun pengguna dan administrator')

@section('content')

{{-- ===== Page Actions ===== --}}
<div class="flex items-center justify-between mb-5">
    <div class="flex items-center gap-2 text-sm text-gray-500">
        <i class="fas fa-users"></i>
        <span>{{ $users->total() }} pengguna terdaftar</span>
    </div>
    <button onclick="openModal('addModal')" class="btn-primary">
        <i class="fas fa-plus"></i> Tambah Pengguna
    </button>
</div>

{{-- ===== Table ===== --}}
<div class="card overflow-hidden fade-in">
    <div class="p-5 border-b border-gray-100">
        <h3 class="font-bold text-gray-800">Daftar Semua Pengguna</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pengguna</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Bergabung</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td class="text-gray-400 font-medium text-xs">
                        {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                    </td>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                                <span class="text-sm font-bold text-green-700">{{ strtoupper(substr($user->name,0,1)) }}</span>
                            </div>
                            <span class="font-semibold text-gray-800">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="text-gray-500">{{ $user->email }}</td>
                    <td>
                        @if($user->role === 'admin')
                            <span class="inline-flex items-center gap-1 bg-purple-50 text-purple-700 border border-purple-200 text-xs font-semibold px-2.5 py-1 rounded-lg">
                                <i class="fas fa-shield-alt text-xs"></i> Admin
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 border border-blue-200 text-xs font-semibold px-2.5 py-1 rounded-lg">
                                <i class="fas fa-user text-xs"></i> User
                            </span>
                        @endif
                    </td>
                    <td class="text-gray-500 text-xs">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button onclick="editUser({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->email }}', '{{ $user->role }}')"
                                    class="btn-edit">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
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
                    <td colspan="6" class="text-center py-12 text-gray-400">
                        <i class="fas fa-users text-3xl mb-2 block opacity-30"></i>
                        Belum ada data pengguna
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="px-5 py-3 border-t border-gray-100">
        {{ $users->links() }}
    </div>
    @endif
</div>


{{-- ===== MODAL: Tambah User ===== --}}
<div id="addModal" class="modal-overlay">
    <div class="modal-box">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-lg font-bold text-gray-900">Tambah Pengguna Baru</h3>
            <button onclick="closeModal('addModal')" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap</label>
                <input type="text" name="name" required class="input-field" placeholder="Nama pengguna">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                <input type="email" name="email" required class="input-field" placeholder="email@contoh.com">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                <input type="password" name="password" required class="input-field" placeholder="Min. 8 karakter">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Role</label>
                <select name="role" required class="input-field">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeModal('addModal')"
                        style="flex:1;padding:0.6rem;border-radius:0.5rem;border:1.5px solid #e2e8f0;font-weight:500;font-size:0.85rem;background:transparent;cursor:pointer;transition:background 0.15s;"
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

{{-- ===== MODAL: Edit User ===== --}}
<div id="editModal" class="modal-overlay">
    <div class="modal-box">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-lg font-bold text-gray-900">Edit Pengguna</h3>
            <button onclick="closeModal('editModal')" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        <form id="editForm" method="POST" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap</label>
                <input type="text" name="name" id="edit_name" required class="input-field">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                <input type="email" name="email" id="edit_email" required class="input-field">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password Baru <span class="text-gray-400 font-normal">(kosongkan jika tidak diubah)</span></label>
                <input type="password" name="password" id="edit_password" class="input-field" placeholder="••••••••">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Role</label>
                <select name="role" id="edit_role" required class="input-field">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeModal('editModal')"
                        style="flex:1;padding:0.6rem;border-radius:0.5rem;border:1.5px solid #e2e8f0;font-weight:500;font-size:0.85rem;background:transparent;cursor:pointer;transition:background 0.15s;"
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
    function editUser(id, name, email, role) {
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_role').value = role;
        document.getElementById('editForm').action = `/admin/users/${id}`;
        openModal('editModal');
    }
    // Close modal on overlay click
    document.querySelectorAll('.modal-overlay').forEach(el => {
        el.addEventListener('click', e => { if (e.target === el) el.classList.remove('active'); });
    });
</script>
@endpush