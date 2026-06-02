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
                <i class="bi bi-box-seam text-primary"></i> Tambah Produk Baru
            </h4>
        </div>
        
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-5 pe-md-4 border-end border-secondary border-opacity-10">
                    <label class="fw-bold mb-2 d-block text-slate-300 text-center">Gambar Produk</label>
                    
                    <div class="text-center border border-secondary border-opacity-20 rounded-4 p-2 mb-3" style="min-height: 350px; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,0.02);">
                        <div id="placeholder-icon" class="text-muted py-5">
                            <i class="bi bi-image fs-1 d-block mb-2 opacity-50"></i>
                            <span class="small opacity-50">Preview Gambar</span>
                        </div>
                        <img id="image-preview" 
                             src="" 
                             class="img-fluid rounded-4 shadow" 
                             alt="" 
                             style="max-height: 350px; width: 100%; object-fit: contain; display: none;">
                    </div>
                    
                    <div class="mb-3">
                        <label for="image" class="form-label fw-semibold text-slate-300">Pilih File Gambar</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror text-white" id="image" accept="image/*" onchange="previewImg()" required style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
                        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <small class="text-muted d-block mt-2">Format: JPG, PNG, atau JPEG. Maksimal 2MB.</small>
                    </div>
                </div>

                <div class="col-md-7 ps-md-4">
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold text-slate-300">Nama Produk</label>
                        <input type="text" name="name" class="form-control text-white @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}" required style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold text-slate-300">Deskripsi Produk</label>
                        <textarea name="description" class="form-control text-white @error('description') is-invalid @enderror" id="description" rows="5" required style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">{{ old('description') }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label fw-semibold text-slate-300">Harga (Rp)</label>
                            <input type="number" name="price" class="form-control text-white @error('price') is-invalid @enderror" id="price" value="{{ old('price') }}" required style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
                            @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="stock" class="form-label fw-semibold text-slate-300">Stok Awal</label>
                            <input type="number" name="stock" class="form-control text-white @error('stock') is-invalid @enderror" id="stock" value="{{ old('stock') }}" required style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
                            @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4 pt-3 border-top border-secondary border-opacity-10">
                <div class="col-12 d-flex justify-content-end gap-2">
                    <a href="{{ route('products.index') }}" class="btn py-2 px-4 text-white opacity-70" style="font-weight: 500;">Batal</a>
                    <button type="submit" class="btn-modern px-5">
                        <i class="bi bi-cloud-arrow-up"></i> Tambahkan
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
        const placeholder = document.querySelector('#placeholder-icon');

        if (image.files && image.files[0]) {
            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                placeholder.style.display = 'none';
                imgPreview.style.display = 'block';
                imgPreview.src = oFREvent.target.result;
            }
        }
    }
</script>
@endsection