@extends('admin.dashboard')

@section('content')
<div class="container">
    <div class="mb-4">
        <a href="{{ route('products.index') }}" class="btn-modern btn-sm py-2 px-3 fs-7" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
            <i class="bi bi-arrow-left-short fs-5 m-0"></i> Kembali ke List
        </a>
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
                             class="img-fluid rounded-4 shadow" 
                             alt="{{ $product->name }}"
<<<<<<< HEAD
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
=======
                             style="max-height: 350px; width: 100%; object-fit: contain;">
                    </div>
                    
                    <div class="mb-3">
                        <label for="image" class="form-label fw-semibold text-slate-300">Ganti Gambar</label>
                        <input type="file" name="image" class="form-control text-white" id="image" accept="image/*" onchange="previewImg()" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
                        <small class="text-muted d-block mt-2">Kosongkan jika tidak ingin mengganti gambar.</small>
                    </div>
                </div>

                <div class="col-md-7 ps-md-4">
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold text-slate-300">Nama Produk</label>
                        <input type="text" name="name" class="form-control text-white @error('name') is-invalid @enderror" id="name" value="{{ old('name', $product->name) }}" required style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold text-slate-300">Deskripsi Produk</label>
                        <textarea name="description" class="form-control text-white @error('description') is-invalid @enderror" id="description" rows="5" required style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">{{ old('description', $product->description) }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label fw-semibold text-slate-300">Harga (Rp)</label>
                            <input type="number" name="price" class="form-control text-white @error('price') is-invalid @enderror" id="price" value="{{ old('price', $product->price) }}" required style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
                            @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="stock" class="form-label fw-semibold text-slate-300">Stok</label>
                            <input type="number" name="stock" class="form-control text-white @error('stock') is-invalid @enderror" id="stock" value="{{ old('stock', $product->stock) }}" required style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
                            @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
>>>>>>> bfce81eaabce70922b9471c6177685f719635e0c
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4 pt-3 border-top border-secondary border-opacity-10">
                <div class="col-12 d-flex justify-content-end gap-2">
                    <a href="{{ route('products.index') }}" class="btn py-2 px-4 text-white opacity-70" style="font-weight: 500;">Batal</a>
                    <button type="submit" class="btn-modern px-5" style="background: linear-gradient(135deg, #06b6d4, #2563eb);">
                        <i class="bi bi-check-circle"></i> Perbarui
                    </button>
                </div>
            </div>
        </form>
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