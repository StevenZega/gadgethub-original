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
                <i class="bi bi-plus-circle text-success"></i> Tambah Produk Baru
            </h4>
        </div>
        
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-5 pe-md-4 border-end border-secondary border-opacity-20">
                    <label class="fw-bold mb-2 d-block text-center text-white text-uppercase tracking-wider small"><i class="bi bi-image"></i> Gambar Produk</label>
                    <div class="text-center border border-secondary border-opacity-20 rounded-4 p-2 mb-3" style="min-height: 350px; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,0.02);">
                        <div id="placeholder-icon" class="text-muted py-5">
                            <i class="bi bi-image fs-1 d-block mb-2 opacity-50"></i>
                            <span class="text-white opacity-50">Preview Gambar</span>
                        </div>
                        <img id="image-preview" class="img-fluid rounded-4 shadow-lg" style="max-height: 340px; width: 100%; object-fit: contain; display: none;">
                    </div>
                    
                    <div class="mb-3">
                        <label for="image" class="form-label fw-bold text-white fs-7 text-uppercase tracking-wider">Upload Gambar</label>
                        <input type="file" name="image" class="form-control text-white input-custom-dark @error('image') is-invalid @enderror" id="image" accept="image/*" onchange="previewImg()" required>
                        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="col-md-7 ps-md-4">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="name" class="form-label fw-bold text-white text-uppercase tracking-wider small">Nama Produk</label>
                            <input type="text" name="name" class="form-control text-white input-custom-dark @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="category" class="form-label fw-bold text-white text-uppercase tracking-wider small">Kategori</label>
                            <select name="category" id="category" class="form-select text-white input-custom-dark @error('category') is-invalid @enderror" required>
                                <option value="" class="bg-dark">-- Pilih Kategori --</option>
                                <option value="Laptop" {{ old('category') == 'Laptop' ? 'selected' : '' }} class="bg-dark">Laptop</option>
                                <option value="Hape" {{ old('category') == 'Hape' ? 'selected' : '' }} class="bg-dark">Hape</option>
                            </select>
                            @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="brand" class="form-label fw-bold text-white text-uppercase tracking-wider small">Brand / Merek</label>
                            <input type="text" name="brand" class="form-control text-white input-custom-dark" id="brand" value="{{ old('brand') }}" required>
                        </div>
                    </div>

                    <div id="laptop-specs" class="p-4 mb-4 rounded-4 border border-secondary border-opacity-20 mt-2" style="background: rgba(255,255,255,0.02); display: none;">
                        <h6 class="text-white mb-3 fw-bold d-flex align-items-center gap-2" style="font-size: 0.85rem; text-transform: uppercase;"><i class="bi bi-cpu-fill text-info"></i> Spesifikasi Laptop</h6>
                        <div class="row g-3">
                            <div class="col-md-6"><label class="text-white small">OS</label><input type="text" id="os_laptop" class="form-control text-white input-custom-dark" placeholder="Windows 11"></div>
                            <div class="col-md-6"><label class="text-white small">RAM (GB)</label><input type="number" id="ram_laptop" class="form-control text-white input-custom-dark"></div>
                            <div class="col-md-6"><label class="text-white small">VGA</label><input type="text" id="vga_laptop" class="form-control text-white input-custom-dark" placeholder="RTX 4060"></div>
                            <div class="col-md-6"><label class="text-white small">Storage (GB)</label><input type="number" id="storage_laptop" class="form-control text-white input-custom-dark"></div>
                            <div class="col-12"><label class="text-white small">Tipe Processor</label><input type="text" id="processor_laptop" class="form-control text-white input-custom-dark" placeholder="Intel i7-13700H"></div>
                        </div>
                    </div>

                    <div id="phone-specs" class="p-4 mb-4 rounded-4 border border-secondary border-opacity-20 mt-2" style="background: rgba(255,255,255,0.02); display: none;">
                        <h6 class="text-white mb-3 fw-bold d-flex align-items-center gap-2" style="font-size: 0.85rem; text-transform: uppercase;"><i class="bi bi-phone-fill text-warning"></i> Spesifikasi Handphone</h6>
                        <div class="row g-3">
                            <div class="col-md-4"><label class="text-white small">OS</label><input type="text" id="os_hape" class="form-control text-white input-custom-dark" placeholder="Android 14"></div>
                            <div class="col-md-4"><label class="text-white small">RAM (GB)</label><input type="number" id="ram_hape" class="form-control text-white input-custom-dark"></div>
                            <div class="col-md-4"><label class="text-white small">Storage (GB)</label><input type="number" id="storage_hape" class="form-control text-white input-custom-dark"></div>
                            <div class="col-md-6"><label class="text-white small">Chipset Processor</label><input type="text" id="processor_hape" class="form-control text-white input-custom-dark" placeholder="Snapdragon 8 Gen 3"></div>
                            <div class="col-md-6"><label class="text-white small">Kamera Utama</label><input type="text" name="rear_camera" class="form-control text-white input-custom-dark" placeholder="50 MP"></div>
                            <div class="col-md-6"><label class="text-white small">Baterai (mAh)</label><input type="number" name="battery_capacity" class="form-control text-white input-custom-dark" placeholder="5000"></div>
                            <div class="col-md-6"><label class="text-white small">Ukuran Layar</label><input type="text" name="screen_size" class="form-control text-white input-custom-dark" placeholder="6.7 inch"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold text-white text-uppercase tracking-wider small">Deskripsi Produk</label>
                        <textarea name="description" class="form-control text-white input-custom-dark" id="description" rows="4" required>{{ old('description') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label fw-bold text-white text-uppercase tracking-wider small">Harga Jual (Rp)</label>
                            <input type="number" name="price" class="form-control text-white input-custom-dark" id="price" value="{{ old('price') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="stock" class="form-label fw-bold text-white text-uppercase tracking-wider small">Stok Gudang</label>
                            <input type="number" name="stock" class="form-control text-white input-custom-dark" id="stock" value="{{ old('stock') }}" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4 pt-3 border-top border-secondary border-opacity-20">
                <div class="col-12 d-flex justify-content-end gap-2">
                    <a href="{{ route('products.index') }}" class="btn py-2 px-4 text-white opacity-70 text-decoration-none" style="font-weight: 500;">Batal</a>
                    <button type="submit" class="btn-modern px-5" style="background: linear-gradient(135deg, #10b981, #059669); border: none; color: #fff;">
                        <i class="bi bi-cloud-arrow-up"></i> Tambahkan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .input-custom-dark { background: rgba(15, 23, 42, 0.6) !important; border: 1px solid rgba(255, 255, 255, 0.15) !important; border-radius: 12px !important; color: #ffffff !important; padding: 0.65rem 1rem !important; }
    .input-custom-dark:focus { background: rgba(15, 23, 42, 0.8) !important; border-color: #3b82f6 !important; box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.25) !important; }
</style>

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

    document.addEventListener('DOMContentLoaded', function () {
        const categorySelect = document.getElementById('category');
        const phoneSpecs = document.getElementById('phone-specs');
        const laptopSpecs = document.getElementById('laptop-specs');

        function updateFormNames() {
            const isLaptop = categorySelect.value === 'Laptop';
            const isHape = categorySelect.value === 'Hape';

            phoneSpecs.style.display = isHape ? 'block' : 'none';
            laptopSpecs.style.display = isLaptop ? 'block' : 'none';

            // Alokasikan atribut NAME secara dinamis agar controller menerima field murni
            document.getElementById('os_laptop').name = isLaptop ? 'os' : '';
            document.getElementById('ram_laptop').name = isLaptop ? 'ram' : '';
            document.getElementById('vga_laptop').name = isLaptop ? 'vga' : '';
            document.getElementById('storage_laptop').name = isLaptop ? 'storage' : '';
            document.getElementById('processor_laptop').name = isLaptop ? 'processor' : '';

            document.getElementById('os_hape').name = isHape ? 'os' : '';
            document.getElementById('ram_hape').name = isHape ? 'ram' : '';
            document.getElementById('storage_hape').name = isHape ? 'storage' : '';
            document.getElementById('processor_hape').name = isHape ? 'processor' : '';
        }

        categorySelect.addEventListener('change', updateFormNames);
        if(categorySelect.value) updateFormNames();
    });
</script>
@endsection