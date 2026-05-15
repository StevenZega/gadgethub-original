@extends('admin.layout')

@section('content')

<div class="container mt-4">

    <h2>Detail Product</h2>

    <div class="card p-4">

        <h3>{{ $product->name }}</h3>

        <img src="{{ asset('storage/' . $product->image) }}"
             width="200"
             class="mb-3">

        <h5>Price :</h5>
        <p>Rp {{ number_format($product->price, 0, ',', '.') }}</p>

        <h5>Stock :</h5>
        <p>{{ $product->stock }}</p>

        <a href="{{ route('products.index') }}"
           class="btn btn-secondary">
            Back
        </a>

    </div>

</div>

@endsection