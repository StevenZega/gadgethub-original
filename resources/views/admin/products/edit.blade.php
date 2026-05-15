@extends('admin.dashboard')

@section('content')

<h3>Edit Product</h3>

<form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
@csrf
@method('PUT')

<input type="text" name="name" value="{{ $product->name }}" class="form-control mb-2">
<input type="number" name="price" value="{{ $product->price }}" class="form-control mb-2">
<input type="number" name="stock" value="{{ $product->stock }}" class="form-control mb-2">
<textarea name="description" class="form-control mb-2">{{ $product->description }}</textarea>

@if($product->image)
    <img src="{{ asset('storage/'.$product->image) }}" width="80">
@endif

<input type="file" name="image" class="form-control mb-2">

<button class="btn btn-primary">Update</button>
</form>

@endsection