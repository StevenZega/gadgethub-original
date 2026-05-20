@extends('admin.layout')
@section('content')

<div class="card-modern">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Daftar Produk</h3>
            <p class="text-muted mb-0">Kelola semua produk toko kamu.</p>
        </div>
        <a href="{{ route('products.create') }}" class="btn btn-dark btn-modern">
            <i class="bi bi-plus-circle"></i> Tambah Produk
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-modern align-middle">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($products as $product)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ asset('storage/' . $product->image) }}"
                                 class="product-image">

                            <div>
                                <h6 class="mb-0 fw-semibold">{{ $product->name }}</h6>
                                <small class="text-muted">Produk toko</small>
                            </div>
                        </div>
                    </td>

                    <td>
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </td>

                    <td>
                        {{ $product->stock }} pcs
                    </td>

                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('products.show', $product->id) }}"
                               class="btn btn-outline-dark btn-sm rounded-3">
                                Detail
                            </a>

                            <a href="{{ route('products.edit', $product->id) }}"
                               class="btn btn-warning btn-sm rounded-3 text-white">
                                Edit
                            </a>

                            <form action="{{ route('products.destroy', $product->id) }}"
                                  method="POST">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm rounded-3">
                                    Hapus
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

@endsection