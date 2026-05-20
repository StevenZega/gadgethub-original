@extends('admin.dashboard')

@section('content')
<div class="container">
    <div class="mb-3">
        <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">< Back to List</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h4 class="fw-bold mb-0">Edit Produk: {{ $product->name }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-5 border-end">
                        <label class="fw-bold mb-2 d-block">Gambar Saat Ini</label>
                        <img id="image-preview" src="{{ asset('storage/' . $product->image) }}" 
                             class="img-fluid rounded shadow-sm mb-3" 
                             alt="{{ $product->name }}"
                             style="width: 100%; height: 350px; object-fit: cover;">
                        <div class="mb-3">
                            <label for="image" class="form-label fw-bold">Ganti Gambar</label>
                            <input type="file" name="image" class="form-control" id="image" accept="image/*" onchange="previewImg()">
                            <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
                        </div>
                    </div>
                    <div class="col-md-7 ps-md-4">
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Nama Produk</label>
                            <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $product->name) }}" required>
                        </div>
                          <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Deskripsi Produk</label>
                            <textarea name="description" class="form-control" id="description" rows="5" required>{{ old('description', $product->description) }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label fw-bold">Harga (Rp)</label>
                                <input type="number" name="price" class="form-control" id="price" value="{{ old('price', $product->price) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="stock" class="form-label fw-bold">Stok</label>
                                <input type="number" name="stock" class="form-control" id="stock" value="{{ old('stock', $product->stock) }}" required>
                            </div>
                        </div>
                        <div class="d-grid pt-3">
                            <button type="submit" class="btn btn-primary btn-lg">Update Produk</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Script simpel biar pas pilih gambar baru, langsung muncul preview-nya
    function previewImg() {
        const image = document.querySelector('#image');
        const imgPreview = document.querySelector('#image-preview');

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
        }
    }
</script>
@endsection