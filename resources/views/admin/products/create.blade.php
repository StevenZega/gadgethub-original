@extends('admin.dashboard')

@section('content')

<h3>Add Product</h3>

<form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
@csrf

<input type="text" name="name" class="form-control mb-2" placeholder="Name">
<input type="number" name="price" class="form-control mb-2" placeholder="Price">
<input type="number" name="stock" class="form-control mb-2" placeholder="Stock">
<textarea name="description" class="form-control mb-2" placeholder="Description"></textarea>
<input type="file" name="image" class="form-control mb-2">

<button class="btn btn-success">Save</button>
</form>

@endsection