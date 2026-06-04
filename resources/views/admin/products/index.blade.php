@extends('admin.dashboard')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold m-0 text-white">Data Produk Gadget</h3>

            <p class="small mb-0 text-white">Total inventaris unit toko Anda saat ini.</p>
        </div>
        <a href="{{ route('products.create') }}" class="btn-modern px-4 py-2.5 d-inline-flex align-items-center fw-semibold text-decoration-none" style="background: linear-gradient(135deg, #a855f7, #6366f1); border-radius: 12px; gap: 8px;">
            <i class="bi bi-plus-lg"></i> Tambah Produk
        </a>
    </div>

    <div class="card-modern p-2 overflow-hidden" style="background: #1e293b; border: 1px solid rgba(255,255,255,0.05); border-radius: 16px;">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0 text-nowrap" style="--bs-table-bg: transparent; border-color: rgba(255,255,255,0.05);">
                <thead>
                    <tr style="color: #a855f7; border-bottom: 2px solid rgba(255,255,255,0.08);">
                        <th class="ps-4 py-3.5 fs-6">Produk</th>
                        <th class="py-3.5 fs-6">Harga</th>
                        <th class="py-3.5 fs-6">Stok</th>
                        <th class="pe-4 py-3.5 fs-6 text-center" style="width: 200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                    <tr style="cursor: pointer; border-bottom: 1px solid rgba(255,255,255,0.05); transition: background 0.2s;" 
                        onclick="window.location='{{ route('products.show', $product->id) }}'"
                        onmouseover="this.style.background='rgba(255,255,255,0.02)'" 
                        onmouseout="this.style.background='transparent'">
                        
                        <td class="ps-4 py-4">
                            <div class="d-flex align-items-center">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="" style="width: 50px; height: 50px; object-fit: cover;" class="rounded-3 border border-secondary border-opacity-25 me-3">
                                @else
                                    <div class="bg-secondary bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; border: 1px dashed rgba(255,255,255,0.15);">
                                        <i class="bi bi-image text-muted fs-4"></i>
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-bold text-white fs-5">{{ $product->name }}</div>
                                    <span class="text-penjelas small">{{ $product->brand ?? 'Gadget' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="text-slate-200 fw-semibold fs-5 py-4">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="py-4">
                            @if($product->stock <= 5)
                                <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill border border-danger border-opacity-10">Sisa {{ $product->stock }} pcs</span>
                            @else
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill border border-success border-opacity-10">{{ $product->stock }} pcs</span>
                            @endif
                        </td>
                        <td class="pe-4 py-4 text-end" onclick="event.stopPropagation();">
                            <div class="d-inline-flex gap-2">
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-warning rounded-3 px-3 py-1.5 fw-medium border-opacity-50">
                                    <i class="bi bi-pencil-square me-1"></i> Edit
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger rounded-3 px-3 py-1.5 fw-medium border-opacity-50" onclick="confirmDelete({{ $product->id }})">
                                    <i class="bi bi-trash me-1"></i> Hapus
                                </button>
                            </div>
                            <form id="delete-form-{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-none">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Produk?',
            text: "Data gadget ini akan dihapus secara permanen!",
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