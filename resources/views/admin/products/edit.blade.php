@extends('admin.dashboard')

@section('content')
<div class="container">
    <div class="mb-4">
        <a href="{{ route('products.index') }}" class="btn-modern btn-sm py-2 px-3 fs-7" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
            <i class="bi bi-arrow-left-short fs-5 m-0"></i> Kembali ke List
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 20px; background: rgba(239, 68, 68, 0.15); backdrop-filter: blur(10px); color: #fca5a5;">
            <p class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill"></i> Terjadi Kesalahan:</p>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card-modern">
        <div class="border-bottom border-secondary border-opacity-10 pb-3 mb-4">
            <h4 class="fw-bold mb-0 text-white d-flex align-items-center gap-2">
                <i class="bi bi-pencil-square text-info"></i> Edit Produk
            </h4>
        </div>
        
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-5 pe-md-4 border-end border-secondary border-opacity-10">
                    <label class="fw-bold mb-2 d-block text-slate-300">Gambar Produk</label>
                    <div class="text-center border border-secondary border-opacity-20 rounded-4 p-2 mb-3" style="min-height: 350px; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,0.02);">
                        <img id="image-preview" src="{{ asset('storage/' . $product->image) }}" 
                             class="img-fluid rounded-4 shadow" 
                             alt="{{ $product->name }}"
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