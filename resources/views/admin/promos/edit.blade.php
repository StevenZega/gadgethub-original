@extends('admin.dashboard')

@section('content')
<div class="container-fluid p-0" style="max-width: 900px; margin: 0 auto;">
    
    <div class="mb-4">
        <a href="{{ route('promos.index') }}" class="btn d-inline-flex align-items-center text-decoration-none px-3 py-2 rounded-3" style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); color: #ffffff !important; font-size: 0.875rem; transition: all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.2)'; this.style.borderColor='rgba(255,255,255,0.4)';" onmouseout="this.style.background='rgba(255, 255, 255, 0.1)'; this.style.borderColor='rgba(255, 255, 255, 0.2)';">
            <i class="bi bi-arrow-left me-2"></i> Kembali ke List Promo
        </a>
    </div>

    <div class="card p-4 shadow-lg mb-5" style="background: #1e293b; border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 14px;">
        
        <div class="border-bottom border-secondary border-opacity-20 pb-3 mb-4">
            <h4 class="fw-bold mb-0 text-white d-flex align-items-center">
                <i class="bi bi-pencil-square text-purple-400 me-2.5 fs-4"></i> Edit Aturan Promo
            </h4>
        </div>

        <form action="{{ route('promos.update', $promo->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label small fw-bold" style="color: #f1f5f9 !important;">Nama Event Promo</label>
                    <input type="text" name="name" class="form-control text-white px-3 py-2.5" value="{{ old('name', $promo->name) }}" required style="background: #0f172a; border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 8px;">
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-bold" style="color: #f1f5f9 !important;">Kode Kupon Promo</label>
                    <input type="text" name="code" class="form-control text-white text-uppercase px-3 py-2.5 tracking-wider fw-bold" value="{{ old('code', $promo->code) }}" required style="background: #0f172a; border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 8px; color: #c084fc !important;">
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label small fw-bold" style="color: #f1f5f9 !important;">Tipe / Cakupan Promo</label>
                    <select name="scope" id="scope" class="form-select text-white px-3 py-2.5" onchange="kondisiFormPromo()" style="background: #0f172a; border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 8px; cursor: pointer;">
                        <option value="all" {{ old('scope', $promo->scope) == 'all' ? 'selected' : '' }}>Semua Produk (Universal)</option>
                        <option value="category" {{ old('scope', $promo->scope) == 'category' ? 'selected' : '' }}>Berdasarkan Kategori</option>
                        <option value="specific" {{ old('scope', $promo->scope) == 'specific' ? 'selected' : '' }}>Produk Spesifik Saja</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-bold" style="color: #f1f5f9 !important;">Besar Potongan (%)</label>
                    <div class="input-group">
                        <input type="number" name="discount_percent" class="form-control text-white px-3 py-2.5" value="{{ old('discount_percent', $promo->discount_percent) }}" min="1" max="100" required style="background: #0f172a; border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 8px 0 0 8px;">
                        <span class="input-group-text text-white px-3" style="background: #334155; border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 0 8px 8px 0;">%</span>
                    </div>
                </div>
            </div>

            <div class="mb-3 {{ old('scope', $promo->scope) == 'category' ? '' : 'd-none' }}" id="input-kategori">
                <label class="form-label small fw-bold" style="color: #f1f5f9 !important;">Target Kategori Produk</label>
                <input type="text" name="category" class="form-control text-white px-3 py-2.5" value="{{ old('category', $promo->category) }}" placeholder="Ketik kategori produk, misal: iPhone, Laptop" style="background: #0f172a; border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 8px;">
            </div>

            <div class="mb-3 {{ old('scope', $promo->scope) == 'specific' ? '' : 'd-none' }}" id="input-produk">
                <label class="form-label small fw-bold" style="color: #f1f5f9 !important;">Pilih Produk Spesifik</label>
                <select name="product_id" class="form-select text-white px-3 py-2.5" style="background: #0f172a; border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 8px;">
                    <option value="">-- Pilih Salah Satu Gadget --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id', $promo->product_id) == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label small fw-bold" style="color: #f1f5f9 !important;">Tanggal Mulai Berlaku</label>
                    <input type="date" name="start_date" class="form-control text-white px-3 py-2.5 shadow-none" value="{{ old('start_date', $promo->start_date ? $promo->start_date->format('Y-m-d') : '') }}" required style="background: #0f172a; border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 8px; color-scheme: dark;">
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-bold" style="color: #f1f5f9 !important;">Tanggal Kedaluwarsa</label>
                    <input type="date" name="end_date" class="form-control text-white px-3 py-2.5 shadow-none" value="{{ old('end_date', $promo->end_date ? $promo->end_date->format('Y-m-d') : '') }}" required style="background: #0f172a; border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 8px; color-scheme: dark;">
                </div>
            </div>

            <div class="d-flex justify-content-end align-items-center gap-2 pt-3 border-top border-secondary border-opacity-20">
                <a href="{{ route('promos.index') }}" class="btn px-4 py-2 text-decoration-none rounded-3" style="background: transparent; border: 1px solid rgba(255,255,255,0.2); color: #cbd5e1 !important; font-size: 0.9rem; transition: all 0.2s;" onmouseover="this.style.color='#fff'; this.style.background='rgba(255,255,255,0.05)'" onmouseout="this.style.color='#cbd5e1'; this.style.background='transparent'">
                    Batal
                </a>
                
                <button type="submit" class="btn text-white px-4 py-2 fw-semibold rounded-3 shadow" style="background: linear-gradient(135deg, #a855f7, #6366f1); border: none; font-size: 0.9rem; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                    Perbarui Aturan Promo
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function kondisiFormPromo() {
        const scope = document.getElementById('scope').value;
        const divKategori = document.getElementById('input-kategori');
        const divProduk = document.getElementById('input-produk');

        divKategori.classList.add('d-none');
        divProduk.classList.add('d-none');

        if (scope === 'category') {
            divKategori.classList.remove('d-none');
        } else if (scope === 'specific') {
            divProduk.classList.remove('d-none');
        }
    }
</script>
@endsection