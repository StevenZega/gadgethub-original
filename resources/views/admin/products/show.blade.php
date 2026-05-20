@extends('admin.dashboard')

@section('content')
<div class="container">
    <div class="mb-3">
        <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">< Back to List</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="row g-0">
            <div class="col-md-5">
                <img src="{{ asset('storage/' . $product->image) }}" 
                     class="img-fluid rounded-start w-100" 
                     alt="{{ $product->name }}"
                     style="height: 400px; object-fit: cover;">
            </div>
            
           <div class="col-md-7">
    <div class="card-body p-4">
        <h1 class="fw-bold mb-3">{{ $product->name }}</h1>

        <div class="mb-4">
            <h6 class="fw-bold text-muted small">Deskripsi Produk</h6>
            <p class="text-secondary">{{ $product->description ?? 'Tidak ada deskripsi.' }}</p>
        </div>

        <div class="d-flex align-items-center gap-4 mb-4">
            <div>
                <h6 class="text-muted small mb-1">Stok</h6>
                <p class="fw-bold mb-0 text-dark">{{ $product->stock ?? 0 }} pcs</p>
            </div>
            
            <div style="border-left: 1px solid #dee2e6; height: 30px;"></div>

            <div>
                <h6 class="text-muted small mb-1">Status</h6>
                <span class="badge {{ ($product->stock > 0) ? 'bg-success' : 'bg-danger' }}">
                    {{ ($product->stock > 0) ? 'Tersedia' : 'Habis' }}
                </span>
            </div>
        </div>

        <hr class="my-4 text-muted opacity-25">

        <div class="mb-4">
            <h6 class="text-muted small mb-1">Harga Satuan</h6>
            <h2 class="text-primary fw-bold">
                Rp {{ number_format($product->price ?? 0, 0, ',', '.') }}
            </h2>
        </div>

        <div class="d-flex gap-2 pt-2">
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning px-4 text-white fw-bold">Edit</a>
            <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger px-4 fw-bold" onclick="return confirm('Hapus produk ini?')">Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection