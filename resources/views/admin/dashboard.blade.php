@extends('admin.layout')

@section('content')

<h1>Dashboard Admin</h1>
<p>Selamat datang di dashboard</p>

<a href="{{ route('products.index') }}" class="btn btn-primary">
    Tambah Produk
</a>

@endsection