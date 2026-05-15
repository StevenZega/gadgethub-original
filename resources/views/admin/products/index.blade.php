@extends('admin.dashboard')

@section('content')

<a href="{{ route('products.create') }}" class="btn btn-primary mb-3">+ Add Product</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($products as $product)
        <tr>
            <td>{{ $product->name }}</td>

            <td>
                <img src="{{ asset('storage/' . $product->image) }}"
                     width="80">
            </td>

            <td>
                <a href="{{ route('products.show', $product->id) }}"
                   class="btn btn-info btn-sm">
                    Read
                </a>

                <a href="{{ route('products.edit', $product->id) }}"
                   class="btn btn-warning btn-sm">
                    Edit
                </a>

                <form action="{{ route('products.destroy', $product->id) }}"
                      method="POST"
                      style="display:inline;">

                    @csrf
                    @method('DELETE')

                    <button class="btn btn-danger btn-sm">
                        Delete
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection