@extends('admin.dashboard')

@section('content')

<div class="card-modern">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Daftar Promo Anda</h3>
            <small class="text-muted">Kelola promo yang Anda buat untuk produk Anda sendiri.</small>
        </div>
        <a href="{{ route('promos.create') }}" class="btn-modern">
            <i class="bi bi-plus-circle"></i> Tambah Promo
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-dark table-hover align-middle">
            <thead>
                <tr>
                    <th>Nama Promo</th>
                    <th>Kode Promo</th>
                    <th>Jenis Cakupan</th>
                    <th>Diskon</th>
                    <th>Kuota</th>
                    <th>Status</th>
                    <th>Waktu Mulai</th>
                    <th>Waktu Berakhir</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($promos as $promo)
                    <tr onclick="window.location.href='{{ route('promos.show', $promo->id) }}'" style="cursor:pointer;">
                        <td><strong>{{ $promo->name }}</strong></td>
                        <td><code class="text-info bg-dark px-2 py-1 rounded fw-bold">{{ $promo->code }}</code></td>
                        <td>
                            @if($promo->scope === 'all')
                                Universal
                            @elseif($promo->scope === 'category')
                                Kategori: {{ $promo->category }}
                            @elseif($promo->scope === 'specific')
                                Produk Spesifik
                            @endif
                        </td>
                        <td>{{ $promo->discount_percent }}%</td>
                        <td>{{ $promo->quota }}</td>
                        <td>
                            @if($promo->is_active == 1)
                                <span class="badge bg-success px-3 py-2 rounded-pill">Aktif</span>
                            @else
                                <span class="badge bg-danger px-3 py-2 rounded-pill">Nonaktif</span>
                            @endif
                        </td>
                        <td>{{ $promo->start_date ? \Carbon\Carbon::parse($promo->start_date)->format('d M Y, H:i') : '-' }} WIB</td>
                        <td>{{ $promo->end_date ? \Carbon\Carbon::parse($promo->end_date)->format('d M Y, H:i') : '-' }} WIB</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('promos.edit', $promo->id) }}" class="btn btn-warning btn-sm" onclick="event.stopPropagation()">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('promos.destroy', $promo->id) }}" method="POST" class="delete-form m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="event.stopPropagation()">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-4 text-muted">Belum ada data promo yang Anda buat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Hapus Promo?',
                text: 'Data promo ini akan dihapus secara permanen!',
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