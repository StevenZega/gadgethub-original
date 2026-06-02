@extends('admin.dashboard')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-white">Inventory Produk</h2>
    <a href="{{ route('products.create') }}" class="btn btn-primary shadow-sm">+ Tambah Produk</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4">Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr style="cursor: pointer;" onclick="window.location='{{ route('products.show', $product->id) }}'">
                    <td class="ps-4">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 alt="" style="width: 45px; height: 45px; object-fit: cover;" 
                                 class="rounded shadow-sm me-3">
                            <div>
                                <div class="fw-bold text-dark">{{ $product->name }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="fw-semibold">Rp {{ number_format($product->price ?? 0, 0, ',', '.') }}</span>
                    </td>
                    <td>
                        {{-- Logika Stok yang Diperbaiki --}}
                        @if($product->stock <= 0)
                            <span class="badge bg-danger px-3">Habis</span>
                        @elseif($product->stock <= 5)
                            <span class="badge bg-warning text-dark px-3">Hampir Habis: {{ $product->stock }}</span>
                        @else
                            <span class="badge bg-success px-3">Tersedia</span>
                        @endif
                    </td>
                    <td class="text-center" onclick="event.stopPropagation();">
                        <div class="btn-group">
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-outline-warning btn-sm">Edit</a>
                            
                            {{-- Form Delete dengan ID unik untuk SweetAlert --}}
                            <form id="delete-form-{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmDelete({{ $product->id }})">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Tambahkan SweetAlert2 via CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Fungsi Konfirmasi Hapus yang Cantik
    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Produk?',
            text: "Data ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545', // Warna merah Bootstrap
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true, // Biar tombol Batal di kiri
            background: '#ffffff',
            customClass: {
                popup: 'rounded-4 shadow',
                title: 'fw-bold text-dark'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    // Tampilkan notifikasi sukses jika ada session('success')
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            customClass: {
                popup: 'rounded-4 shadow'
            }
        });
    @endif
</script>

<style>
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
        transition: 0.2s;
    }
    .badge {
        font-weight: 600;
        letter-spacing: 0.3px;
    }
</style>

@endsection