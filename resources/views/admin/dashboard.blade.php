@extends('admin.layout')

@section('content')

<div class="row g-4 mb-4">

    <div class="col-md-4">
        <div class="card-modern">
            <h6 class="text-white">Total Produk</h6>
            <h2 class="fw-bold">120</h2>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-modern">
            <h6 class="text-white">Penjualan Hari Ini</h6>
            <h2 class="fw-bold">Rp 2.500.000</h2>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-modern">
            <h6 class="text-white">Pesanan Masuk</h6>
            <h2 class="fw-bold">18</h2>
        </div>
    </div>

</div>

<div class="card-modern">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-bold mb-1">Selamat Datang 👋</h4>
            <p class="text-muted mb-0">
                Kelola semua data produk dan pantau performa toko dengan tampilan modern.
            </p>
        </div>

        <a href="{{ route('products.index') }}" class="btn btn-dark btn-modern">
            Kelola Produk
        </a>
    </div>
</div>

@endsection