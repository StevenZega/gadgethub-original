@extends('admin.dashboard')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold m-0 text-white">Data Produk Gadget</h3>
            <p class="text-penjelas small mb-0">Total inventaris unit toko Anda saat ini.</p>
        </div>
        <a href="{{ route('products.create') }}" class="btn-modern">
            <i class="bi bi-plus-lg"></i> Tambah Produk
        </a>
    </div>

    <div class="card-modern p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0 text-nowrap" style="--bs-table-bg: transparent; border-color: rgba(255,255,255,0.05);">
                <thead>
                    <tr style="color: #06b6d4; border-bottom: 2px solid rgba(255,255,255,0.08);">
                        <th class="ps-4 py-3">Gambar</th>
                        <th class="py-3">Nama Produk</th>
                        <th class="py-3">Harga</th>
                        <th class="py-3">Stok</th>
                        <th class="pe-4 py-3 text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                        <td class="ps-4 py-3">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" width="55" class="rounded-3 shadow-sm" alt="" style="object-fit: cover; aspect-ratio: 1/1;">
                            @else
                                <div class="bg-secondary rounded-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 55px; height: 55px; opacity: 0.3;">
                                    <i class="bi bi-image text-white"></i>
                                </div>
                            @endif
                        </td>
                        <td class="text-white fw-semibold">{{ $product->name }}</td>
                        <td class="text-slate-300">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>
                            @if($product->stock <= 5)
                                <span class="badge bg-danger bg-opacity-10 text-danger px-2.5 py-1.5 rounded-pill">Sisa {{ $product->stock }} pcs</span>
                            @else
                                <span class="badge bg-success bg-opacity-10 text-success px-2.5 py-1.5 rounded-pill">{{ $product->stock }} pcs</span>
                            @endif
                        </td>
                        <td class="pe-4 text-end">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-outline-info rounded-3 px-3">Detail</a>
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-warning rounded-3 px-3">Edit</a>
                                <button type="button" class="btn btn-sm btn-outline-danger rounded-3 px-3" onclick="confirmDelete({{ $product->id }})">Hapus</button>
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

{{-- Memastikan script SweetAlert2 tetap berjalan jika dibutuhkan --}}
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