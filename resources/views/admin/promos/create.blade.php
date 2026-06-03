@extends('admin.dashboard')

@section('content')
<div class="container" style="max-width: 850px;">
    <div class="mb-4">
        <a href="{{ route('promos.index') }}" class="btn-modern btn-sm py-2 px-3 fs-7" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
            <i class="bi bi-arrow-left-short fs-5 m-0"></i> Kembali ke List Promo
        </a>
    </div>

    <div class="card-modern p-4">
        <div class="border-bottom border-secondary border-opacity-10 pb-3 mb-4">
            <h4 class="fw-bold mb-0 text-white">
                <i class="bi bi-ticket-perforated-fill text-purple-400 me-2"></i> Buat Aturan Promo Baru
            </h4>
        </div>

        <form action="{{ route('promos.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold text-slate-300">Kode Kupon Promo</label>
                    <input type="text" name="code" class="form-control text-white text-uppercase" placeholder="Contoh: BCAULTAH5" required style="background: rgba(255,255,255,0.02); border-color: rgba(255,255,255,0.1);">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold text-slate-300">Nama Event Promo</label>
                    <input type="text" name="name" class="form-control text-white" placeholder="Contoh: HUT BCA Diskon 5%" required style="background: rgba(255,255,255,0.02); border-color: rgba(255,255,255,0.1);">
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold text-slate-300">Tipe / Cakupan Promo</label>
                    <select name="scope" id="scope" class="form-select text-white" onchange="kondisiForm Promo()" style="background: #1e293b; border-color: rgba(255,255,255,0.1);">
                        <option value="all">Semua Produk (Universal / All Items)</option>
                        <option value="category">Berdasarkan Kategori</option>
                        <option value="specific">Produk Spesifik Saja</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold text-slate-300">Besar Potongan (%)</label>
                    <input type="number" name="discount_percent" class="form-control text-white" placeholder="1 - 100" min="1" max="100" required style="background: rgba(255,255,255,0.02); border-color: rgba(255,255,255,0.1);">
                </div>
            </div>

            <div class="mb-3 d-none" id="input-kategori">
                <label class="form-label fw-bold text-slate-300">Target Kategori Produk</label>
                <input type="text" name="category" class="form-control text-white" placeholder="Ketik kategori produk, misal: iPhone, Laptop, Android" style="background: rgba(255,255,255,0.02); border-color: rgba(255,255,255,0.1);">
            </div>

            <div class="mb-3 d-none" id="input-produk">
                <label class="form-label fw-bold text-slate-300">Pilih Produk Spesifik</label>
                <select name="product_id" class="form-select text-white" style="background: #1e293b; border-color: rgba(255,255,255,0.1);">
                    <option value="">-- Pilih Salah Satu Gadget --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="row mt-2">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold text-slate-300">Tanggal Mulai Berlaku</label>
                    <input type="date" name="start_date" class="form-control text-white" required style="background: rgba(255,255,255,0.02); border-color: rgba(255,255,255,0.1);">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold text-slate-300">Tanggal Kedaluwarsa</label>
                    <input type="date" name="end_date" class="form-control text-white" required style="background: rgba(255,255,255,0.02); border-color: rgba(255,255,255,0.1);">
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top border-secondary border-opacity-10">
                <a href="{{ route('promos.index') }}" class="btn py-2 px-4 text-white opacity-70">Batal</a>
                <button type="submit" class="btn-modern px-5" style="background: linear-gradient(135deg, #a855f7, #6366f1);">
                    Simpan & Rilis Promo
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

        // Sembunyikan semua dulu
        divKategori.classList.add('d-none');
        divProduk.classList.add('d-none');

        // Munculkan sesuai pilihan admin
        if (scope === 'category') {
            divKategori.classList.remove('d-none');
        } else if (scope === 'specific') {
            divProduk.classList.remove('d-none');
        }
    }
</script>
@endsection