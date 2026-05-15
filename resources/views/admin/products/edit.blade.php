@extends('admin.dashboard')

@section('content')
<div class="container">
    <div class="mb-3">
        <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">< Back to List</a>
    </div>

    <div class="card border-0 shadow-sm overflow-hidden bg-white" style="border-radius: 15px;">
        <div class="card-header bg-white py-3 border-bottom-0">
            <h4 class="fw-bold mb-0 text-dark">Edit Detail Produk</h4>
        </div>
        
        <div class="card-body p-4">
            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-5 pe-md-4">
                        <label class="fw-bold mb-2 d-block text-dark">Gambar Saat Ini</label>
                        <img id="image-preview" src="{{ asset('storage/' . $product->image) }}" 
                             class="img-fluid rounded shadow-sm mb-3" 
                             alt="{{ $product->name }}"
                             style="width: 100%; height: 350px; object-fit: cover;">
                        
                        <div class="mb-3">
                            <label for="image" class="form-label fw-bold text-dark">Ganti Gambar</label>
                            <input type="file" name="image" class="form-control bg-light" id="image" accept="image/*" onchange="previewImg()">
                            <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
                        </div>
                    </div>

                    <div class="col-md-7 ps-md-4">
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold text-dark">Nama Produk</label>
                            <input type="text" name="name" class="form-control bg-light" id="name" value="{{ old('name', $product->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold text-dark">Deskripsi Produk</label>
                            <textarea name="description" class="form-control bg-light" id="description" rows="5" required>{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label fw-bold text-dark">Harga (Rp)</label>
                                <input type="number" name="price" class="form-control bg-light" id="price" value="{{ old('price', $product->price) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="stock" class="form-label fw-bold text-dark">Stok</label>
                                <input type="number" name="stock" class="form-control bg-light" id="stock" value="{{ old('stock', $product->stock) }}" required>
                            </div>
                        </div>

                        <div class="d-grid pt-3">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold shadow-sm">Update Produk</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImg() {
        const image = document.querySelector('#image');
        const imgPreview = document.querySelector('#image-preview');

        if (image.files && image.files[0]) {
            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    }
</script>
@endsection