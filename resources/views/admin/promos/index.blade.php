@extends('admin.dashboard')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold m-0 text-white">Daftar Promo Aktif</h2>
            <p class="text-penjelas small mb-0">Semua skema diskon toko dikendalikan dari halaman khusus ini.</p>
        </div>
        <a href="{{ route('promos.create') }}" class="btn-modern px-4 py-2.5 d-inline-flex align-items-center fw-semibold text-decoration-none" style="background: linear-gradient(135deg, #a855f7, #6366f1); border-radius: 12px; gap: 8px;">
            <i class="bi bi-plus-lg"></i> Buat Aturan Promo
        </a>
    </div>

    <div class="card-modern p-2 overflow-hidden" style="background: #1e293b; border: 1px solid rgba(255,255,255,0.05); border-radius: 16px;">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0 text-nowrap" style="--bs-table-bg: transparent; border-color: rgba(255,255,255,0.05);">
                <thead>
                    <tr style="color: #a855f7; border-bottom: 2px solid rgba(255,255,255,0.08);">
                        <th class="ps-4 py-3.5 fs-6">Nama Event</th>
                        <th class="py-3.5 fs-6">Kode</th>
                        <th class="py-3.5 fs-6">Jenis Cakupan</th>
                        <th class="py-3.5 fs-6 text-center">Besar Potongan</th>
                        <th class="py-3.5 fs-6">Masa Berlaku</th>
                        <th class="pe-4 py-3.5 fs-6 text-end col-aksi">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($promos as $promo)
                    <tr style="cursor: pointer; border-bottom: 1px solid rgba(255,255,255,0.05); transition: background 0.2s;" 
                        onclick="window.location='{{ route('promos.show', $promo->id) }}'"
                        onmouseover="this.style.background='rgba(255,255,255,0.02)'" 
                        onmouseout="this.style.background='transparent'">
                        
                        <td class="ps-4 py-4 text-white fw-semibold fs-5">{{ $promo->name }}</td>
                        <td class="py-4 fw-bold text-purple-400 tracking-wider font-monospace fs-5">{{ $promo->code }}</td>
                        <td class="py-4">
                            @if($promo->scope == 'all')
                                <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill fs-7 border border-info border-opacity-10">Universal (All Items)</span>
                            @elseif($promo->scope == 'category')
                                <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill fs-7 border border-warning border-opacity-10">Per Kategori</span>
                            @else
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fs-7 border border-primary border-opacity-10">Produk Spesifik</span>
                            @endif
                        </td>
                        <td class="text-center text-emerald-400 fw-bold fs-5 py-4">{{ $promo->discount_percent }}%</td>
                        <td class="text-slate-400 fs-7 py-4">
                            <i class="bi bi-calendar3 me-2 text-purple-300"></i>
                            {{ date('d M Y', strtotime($promo->start_date)) }} <span class="text-penjelas mx-1">s/d</span> {{ date('d M Y', strtotime($promo->end_date)) }}
                        </td>
                        <td class="pe-4 py-4 text-end" onclick="event.stopPropagation();">
                            <div class="d-inline-flex gap-2">
                                <a href="{{ route('promos.edit', $promo->id) }}" class="btn btn-sm btn-outline-warning rounded-3 px-3 py-1.5 fw-medium border-opacity-50">
                                    <i class="bi bi-pencil-square me-1"></i> Edit
                                </a>

                                <button type="button" class="btn btn-sm btn-outline-danger rounded-3 px-3 py-1.5 fw-medium border-opacity-50" onclick="confirmDeletePromo({{ $promo->id }})">
                                    <i class="bi bi-trash3 me-1"></i> Hapus
                                </button>

                                <form id="delete-form-{{ $promo->id }}" action="{{ route('promos.destroy', $promo->id) }}" method="POST" class="d-none">
                                    @csrf @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .table-responsive::-webkit-scrollbar { height: 6px; background: transparent; }
    .table-responsive::-webkit-scrollbar-track { background: rgba(255, 255, 255, 0.02); border-radius: 20px; }
    .table-responsive::-webkit-scrollbar-thumb { background: linear-gradient(135deg, rgba(168, 85, 247, 0.4), rgba(99, 102, 241, 0.4)); border-radius: 20px; }
    .table-responsive::-webkit-scrollbar-thumb:hover { background: linear-gradient(135deg, rgba(168, 85, 247, 0.8), rgba(99, 102, 241, 0.8)); }
    .table th, .table td { padding-left: 20px !important; padding-right: 20px !important; }
    .col-aksi { width: 140px; }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDeletePromo(id) {
        Swal.fire({
            title: 'Hapus Aturan Promo?',
            text: "Skema diskon dan kupon ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            background: '#1e293b',
            customClass: {
                popup: 'rounded-4 border border-secondary text-white shadow-lg',
                title: 'fw-bold text-white',
                htmlContainer: 'text-penjelas'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endsection