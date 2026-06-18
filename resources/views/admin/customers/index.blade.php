@extends('admin.dashboard')

@section('content')

<div class="card-modern p-4" style="background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(20px); border-radius: 24px; border: 1px solid rgba(255, 255, 255, 0.08);">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1 text-white">Daftar Pelanggan</h3>
            <p class="text-light opacity-50 mb-0">Pantau dan kelola seluruh akun customer yang terdaftar di GadgetHub.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 text-white bg-success bg-opacity-75 mb-4">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-dark table-hover align-middle m-0">
            <thead>
                <tr class="border-bottom border-secondary">
                    <th width="80" class="py-3">Avatar</th>
                    <th class="py-3">Nama Lengkap</th>
                    <th class="py-3">Alamat Email</th>
                    <th class="py-3">Status</th>
                    <th class="py-3">Tanggal Bergabung</th>
                    <th width="180" class="text-center py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                    <tr onclick="window.location.href='{{ route('customer-profiles.show', $customer->id) }}'" style="cursor:pointer; border-bottom: 1px solid rgba(255,255,255,0.05);">
                        <td class="py-3">
                            <div class="avatar-placeholder">
                                <i class="bi bi-person-circle fs-3 text-secondary"></i>
                            </div>
                        </td>
                        <td class="py-3"><strong>{{ $customer->name }}</strong></td>
                        <td class="py-3"><span class="text-info font-monospace">{{ $customer->email }}</span></td>
                        <td class="py-3">
                            <!-- Status otomatis aktif karena akun terdaftar & bisa login -->
                            <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-50 px-2 py-1 rounded-pill"><i class="bi bi-circle-fill me-1" style="font-size: 8px;"></i> Aktif</span>
                        </td>
                        <td class="py-3">{{ $customer->created_at ? $customer->created_at->format('d M Y') : '-' }}</td>
                        <td class="py-3">
                            <div class="d-flex justify-content-center">
                                <!-- Hanya ada tombol hapus, tombol detail sudah dibuang -->
                                <form action="{{ route('customer-profiles.destroy', $customer->id) }}" method="POST" class="delete-form m-0" onclick="event.stopPropagation()">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm px-3">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-white">Belum ada customer yang mendaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
.avatar-placeholder {
    width: 40px;
    height: 40px;
    background: rgba(255,255,255,0.05);
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    border: 1px solid rgba(255,255,255,0.1);
}
table tbody tr:hover {
    background-color: rgba(255, 255, 255, 0.02) !important;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Hapus Akun Pelanggan?',
                text: 'Akun ini beserta seluruh data di dalamnya akan dihapus permanen dari sistem!',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: '#1e293b',
                color: '#ffffff',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>

@endsection