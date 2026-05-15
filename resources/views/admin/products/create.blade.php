@extends('admin.dashboard')

@section('content')
<div class="container">
    <div class="mb-3">
        <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">< Back to List</a>
    </div>

    <div class="card border-0 shadow-sm overflow-hidden bg-white" style="border-radius: 15px;">
        <div class="card-header bg-white py-3 border-bottom-0">
            <h4 class="fw-bold mb-0 text-dark">Tambah Produk Baru</h4>
        </div>
        
        <div class="card-body p-4">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-5 pe-md-4 border-end">
                        <label class="fw-bold mb-2 d-block text-dark text-center">Gambar Produk</label>
                        
                        <div class="text-center border rounded p-2 bg-light mb-3" style="min-height: 350px; display: flex; align-items: center; justify-content: center; overflow: hidden; background-color: #f8f9fa;">
                            <img id="image-preview" 
                                 src="" 
                                 class="img-fluid rounded shadow-sm" 
                                 alt="" 
                                 style="max-height: 350px; width: 100%; object-fit: cover; display: none;">
                        </div>
                        
                        <div class="mb-3">
                            <label for="image" class="form-label fw-bold text-dark">Pilih File Gambar</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" id="image" accept="image/*" onchange="previewImg()" required>
                            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted d-block mt-2">Format: JPG, PNG, atau JPEG. Maksimal 2MB.</small>
                        </div>
                    </div>

                    <div class="col-md-7 ps-md-4">
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold text-dark">Nama Produk</label>
                            <input type="text" name="name" class="form-control bg-light @error('name') is-invalid @enderror" id="name" placeholder="Masukkan nama produk" value="{{ old('name') }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold text-dark">Deskripsi Produk</label>
                            <textarea name="description" class="form-control bg-light @error('description') is-invalid @enderror" id="description" rows="5" placeholder="Jelaskan detail produk secara lengkap..." required>{{ old('description') }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label fw-bold text-dark">Harga (Rp)</label>
                                <input type="number" name="price" class="form-control bg-light @error('price') is-invalid @enderror" id="price" placeholder="Contoh: 50000" value="{{ old('price') }}" required>
                                @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="stock" class="form-label fw-bold text-dark">Stok Awal</label>
                                <input type="number" name="stock" class="form-control bg-light @error('stock') is-invalid @enderror" id="stock" placeholder="0" value="{{ old('stock') }}" required>
                                @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="d-grid pt-3">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold shadow-sm">Simpan Produk</button>
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
                // Sembunyikan tulisan 'broken image' atau teks alt dengan cara display block hanya saat ada file
                imgPreview.style.display = 'block';
                imgPreview.src = oFREvent.target.result;
            }
        }
    }
</script>
@endsection