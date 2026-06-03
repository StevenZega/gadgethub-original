@extends('admin.dashboard')

@section('content')
<div class="container">
    <div class="mb-4">
        <a href="{{ route('products.index') }}" class="btn-modern btn-sm py-2 px-3 fs-7 text-decoration-none d-inline-flex align-items-center gap-1" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px); color: #fff;">
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

    <div class="card-modern text-white shadow-lg" style="background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.05); border-radius: 24px; padding: 2rem;">
        <div class="border-bottom border-secondary border-opacity-20 pb-3 mb-4">
            <h4 class="fw-bold mb-0 text-white d-flex align-items-center gap-2">
                <i class="bi bi-pencil-square text-info"></i> Edit Aturan & Spesifikasi Produk
            </h4>
        </div>
        
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-5 pe-md-4 border-end border-secondary border-opacity-20">
                    <label class="custom-header-label mb-2 d-block text-center"><i class="bi bi-image"></i> Gambar Produk</label>
                    <div class="text-center border border-secondary border-opacity-20 rounded-4 p-2 mb-3" style="min-height: 350px; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,0.02);">
                        @if($product->image)
                            <img id="image-preview" src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded-4 shadow-lg" alt="{{ $product->name }}" style="max-height: 340px; width: 100%; object-fit: contain;">
                        @else
                            <div id="image-placeholder" class="text-muted py-5">
                                <i class="bi bi-image fs-1 d-block mb-2 opacity-50"></i><span class="text-white opacity-50">Tidak Ada Gambar</span>
                            </div>
                            <img id="image-preview" class="img-fluid rounded-4 shadow-lg d-none" style="max-height: 340px; width: 100%; object-fit: contain;">
                        @endif
                    </div>
                    
                    <div class="mb-3">
                        <label for="image" class="form-label fw-bold text-white fs-7 text-uppercase tracking-wider">Ganti File Gambar</label>
                        <input type="file" name="image" class="form-control text-white input-custom-dark" id="image" accept="image/*" onchange="previewImg()">
                        <small class="text-light-muted d-block mt-2"><i class="bi bi-info-circle"></i> Biarkan kosong jika tidak ingin mengubah foto produk aktif.</small>
                    </div>
                </div>

                <div class="col-md-7 ps-md-4">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="name" class="form-label fw-bold text-white text-uppercase tracking-wider small">Nama Produk</label>
                            <input type="text" name="name" class="form-control text-white input-custom-dark" id="name" value="{{ old('name', $product->name) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold text-white text-uppercase tracking-wider small">Deskripsi Produk</label>
                            <textarea name="description" class="form-control text-white input-custom-dark" id="description" rows="4" required>{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-white text-uppercase tracking-wider small">Kategori</label>
                            <input type="text" name="category" class="form-control text-white input-custom-dark fw-bold" value="{{ $product->category }}" readonly style="background: rgba(255,255,255,0.05) !important; cursor: not-allowed;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="brand" class="form-label fw-bold text-white text-uppercase tracking-wider small">Merek</label>
                            <input type="text" name="brand" class="form-control text-white input-custom-dark" id="brand" value="{{ old('brand', $product->brand) }}" required>
                        </div>
                    </div>

                    <div class="p-4 mb-4 rounded-4 border border-secondary border-opacity-20 mt-2" style="background: rgba(255,255,255,0.02);">
                        <h6 class="text-white mb-3 fw-bold d-flex align-items-center gap-2" style="font-size: 0.85rem; text-transform: uppercase;"><i class="bi bi-cpu-fill text-info"></i> Input Spesifikasi Fisik {{ $product->category }}</h6>

                        @if($product->category === 'Laptop')
                            <div class="row g-3">
                                <div class="col-md-6"><label class="text-white small">Operating System (OS)</label><input type="text" name="os" class="form-control text-white input-custom-dark" value="{{ old('os', $product->os) }}"></div>
                                <div class="col-md-6"><label class="text-white small">Kapasitas RAM (GB)</label><input type="number" name="ram" class="form-control text-white input-custom-dark" value="{{ old('ram', $product->ram) }}"></div>
                                <div class="col-md-6"><label class="text-white small">Kartu Grafis (VGA)</label><input type="text" name="vga" class="form-control text-white input-custom-dark" value="{{ old('vga', $product->vga) }}"></div>
                                <div class="col-md-6"><label class="text-white small">Penyimpanan / Storage (GB)</label><input type="number" name="storage" class="form-control text-white input-custom-dark" value="{{ old('storage', $product->storage) }}"></div>
                                <div class="col-12"><label class="text-white small">Tipe Processor</label><input type="text" name="processor" class="form-control text-white input-custom-dark" value="{{ old('processor', $product->processor) }}" placeholder="Contoh: Intel Core i7-13700H"></div>
                            </div>
                        @endif

                        @if($product->category === 'Hape')
                            <div class="row g-3">
                                <div class="col-md-4"><label class="text-white small">Sistem Operasi</label><input type="text" name="os" class="form-control text-white input-custom-dark" value="{{ old('os', $product->os) }}"></div>
                                <div class="col-md-4"><label class="text-white small">RAM (GB)</label><input type="number" name="ram" class="form-control text-white input-custom-dark" value="{{ old('ram', $product->ram) }}"></div>
                                <div class="col-md-4"><label class="text-white small">Internal Storage (GB)</label><input type="number" name="storage" class="form-control text-white input-custom-dark" value="{{ old('storage', $product->storage) }}"></div>
                                <div class="col-md-6"><label class="text-white small">Chipset Processor</label><input type="text" name="processor" class="form-control text-white input-custom-dark" value="{{ old('processor', $product->processor) }}" placeholder="Contoh: Snapdragon 8 Gen 3"></div>
                                <div class="col-md-6"><label class="text-white small">Kamera Utama</label><input type="text" name="rear_camera" class="form-control text-white input-custom-dark" value="{{ old('rear_camera', $product->rear_camera) }}"></div>
                                <div class="col-md-6"><label class="text-white small">Daya Baterai (mAh)</label><input type="number" name="battery_capacity" class="form-control text-white input-custom-dark" value="{{ old('battery_capacity', $product->battery_capacity) }}"></div>
                                <div class="col-md-6"><label class="text-white small">Dimensi Layar</label><input type="text" name="screen_size" class="form-control text-white input-custom-dark" value="{{ old('screen_size', $product->screen_size) }}"></div>
                            </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label fw-bold text-white text-uppercase tracking-wider small">Harga Jual (Rp)</label>
                            <input type="number" name="price" class="form-control text-white input-custom-dark" id="price" value="{{ old('price', $product->price) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="stock" class="form-label fw-bold text-white text-uppercase tracking-wider small">Stok</label>
                            <input type="number" name="stock" class="form-control text-white input-custom-dark" id="stock" value="{{ old('stock', $product->stock) }}" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4 pt-3 border-top border-secondary border-opacity-20">
                <div class="col-12 d-flex justify-content-end gap-2">
                    <a href="{{ route('products.index') }}" class="btn py-2 px-4 text-white opacity-70 text-decoration-none">Batal</a>
                    <button type="submit" class="btn-modern px-5" style="background: linear-gradient(135deg, #06b6d4, #2563eb); border: none; color: #fff;">
                        <i class="bi bi-check-circle"></i> Perbarui Data
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .custom-header-label { font-weight: 700 !important; font-size: 0.85rem !important; color: #ffffff !important; text-transform: uppercase !important; letter-spacing: 0.05em !important; }
    .input-custom-dark { background: rgba(15, 23, 42, 0.6) !important; border: 1px solid rgba(255, 255, 255, 0.15) !important; border-radius: 12px !important; color: #ffffff !important; padding: 0.65rem 1rem !important; }
    .text-light-muted { color: #cbd5e1 !important; font-size: 0.8rem; }
</style>

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