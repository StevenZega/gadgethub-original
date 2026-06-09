@extends('admin.dashboard')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">

<style>
    .promo-card{
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.08);
        backdrop-filter: blur(18px);
        border-radius: 24px;
        overflow: hidden;
    }

    .promo-header{
        padding: 25px 30px;
        border-bottom: 1px solid rgba(255,255,255,0.08);
        display:flex;
        justify-content:space-between;
        align-items:center;
    }

    .promo-title{
        font-size:1.5rem;
        font-weight:700;
        margin:0;
    }

    .promo-subtitle{
        color:#94a3b8;
        margin-top:5px;
        font-size:.9rem;
    }

    .promo-body{
        padding:30px;
    }

    .form-label{
        color:#e2e8f0;
        font-weight:600;
        margin-bottom:10px;
    }

    .modern-input{
        background: rgba(255, 255, 255, 0.06);
        border:1px solid rgba(255,255,255,0.08);
        color:white;
        border-radius:16px;
        padding:14px 18px;
        height:58px;
    }

    .modern-input:focus{
        background: rgba(0, 0, 0, 0.08);
        color:white;
        border-color:#3b82f6;
        box-shadow:0 0 0 4px rgba(59,130,246,.15);
    }

    .modern-input option {
        background-color: #1e293b;
        color: white;
    }

    .action-area{
        border-top:1px solid rgba(255,255,255,0.08);
        padding-top:25px;
        margin-top:10px;
    }

    .btn-save{
        background: linear-gradient(135deg,#2563eb,#06b6d4);
        border:none;
        padding:12px 26px;
        border-radius:14px;
        font-weight:600;
        color:white;
    }

    .btn-cancel{
        border:1px solid rgba(255,255,255,0.15);
        color:#cbd5e1;
        padding:12px 24px;
        border-radius:14px;
    }

    /* THEME DARK MODE UNTUK TOM SELECT SPECIFIC PRODUCT */
    .ts-wrapper.single .ts-control {
        background: rgba(255, 255, 255, 0.06) !important;
        border: 1px solid rgba(255,255,255,0.08) !important;
        color: white !important;
        border-radius: 16px !important;
        padding: 14px 18px !important;
        height: 58px !important;
        display: flex;
        align-items: center;
    }
    .ts-wrapper.single .ts-control input { color: white !important; }
    .ts-wrapper.single .ts-control .item { color: white !important; }
    .ts-wrapper.single .ts-control::after { border-color: #94a3b8 transparent transparent transparent !important; }
    .ts-dropdown {
        background: #1e293b !important;
        border: 1px solid rgba(255,255,255,0.15) !important;
        border-radius: 14px !important;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5) !important;
        margin-top: 5px !important;
    }
    .ts-dropdown .option { padding: 12px 18px !important; color: #cbd5e1 !important; }
    .ts-dropdown .active { background: #2563eb !important; color: white !important; }
</style>

<div class="promo-card">
    <div class="promo-header">
        <div>
            <h2 class="promo-title"><i class="bi bi-pencil-square text-warning"></i> Edit Promo</h2>
            <div class="promo-subtitle">Perbarui data promo beserta pengaturan jam aktifnya.</div>
        </div>
    </div>

    <div class="promo-body">
        @if ($errors->any())
            <div class="alert alert-danger text-white bg-danger border-0 rounded-4 p-3 mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('promos.update', $promo->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="form-label">Nama Promo</label>
                    <input type="text" name="name" class="form-control modern-input" value="{{ old('name', $promo->name) }}" required>
                </div>

                <div class="col-md-6 mb-4">
                    <label class="form-label">Kode Promo</label>
                    <input type="text" name="code" class="form-control modern-input" value="{{ old('code', $promo->code) }}" required>
                </div>

                <div class="col-md-6 mb-4">
                    <label class="form-label">Jenis Cakupan</label>
                    <select name="jenis_cakupan" id="jenis_cakupan" class="form-select modern-input" required>
                        <option value="all" {{ old('jenis_cakupan', $promo->scope) == 'all' ? 'selected' : '' }}>Universal</option>
                        <option value="category" {{ old('jenis_cakupan', $promo->scope) == 'category' ? 'selected' : '' }}>Per Kategori</option>
                        <option value="specific" {{ old('jenis_cakupan', $promo->scope) == 'specific' ? 'selected' : '' }}>Produk Spesifik</option>
                    </select>
                </div>

                <div class="col-md-6 mb-4" id="field_category" style="display: none;">
                    <label class="form-label">Pilih Kategori Target</label>
                    <select name="category" class="form-select modern-input">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Laptop" {{ old('category', $promo->category) == 'Laptop' ? 'selected' : '' }}>Laptop</option>
                        <option value="Handphone" {{ old('category', $promo->category) == 'Handphone' ? 'selected' : '' }}>Handphone</option>
                    </select>
                </div>

                <div class="col-md-6 mb-4" id="field_product_id" style="display: none;">
                    <label class="form-label">Pilih Produk Target</label>
                    <select name="product_id" id="product_select" placeholder="Cari atau pilih produk...">
                        <option value=""></option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id', $promo->product_id) == $product->id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-4">
                    <label class="form-label">Diskon (%)</label>
                    <input type="number" name="discount_percent" class="form-control modern-input" min="1" max="100" value="{{ old('discount_percent', $promo->discount_percent) }}" required>
                </div>

                <div class="col-md-6 mb-4">
                    <label class="form-label">Kuota Promo</label>
                    <input type="number" name="quota" class="form-control modern-input" min="0" value="{{ old('quota', $promo->quota) }}" required>
                </div>

                <div class="col-md-6 mb-4">
                    <label class="form-label">Status Promo</label>
                    <select name="status" class="form-select modern-input" required>
                        <option value="aktif" {{ old('status', $promo->is_active == 1 ? 'aktif' : 'nonaktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status', $promo->is_active == 1 ? 'aktif' : 'nonaktif') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

                <div class="col-md-6 mb-4">
                    <label class="form-label">Waktu Mulai (Tanggal & Jam)</label>
                    <input type="datetime-local" name="start_date" class="form-control modern-input" value="{{ old('start_date', $promo->start_date ? \Carbon\Carbon::parse($promo->start_date)->format('Y-m-d\TH:i') : '') }}" required>
                </div>

                <div class="col-md-6 mb-4">
                    <label class="form-label">Waktu Berakhir (Tanggal & Jam)</label>
                    <input type="datetime-local" name="end_date" class="form-control modern-input" value="{{ old('end_date', $promo->end_date ? \Carbon\Carbon::parse($promo->end_date)->format('Y-m-d\TH:i') : '') }}" required>
                </div>
            </div>

            <div class="action-area mt-3">
                <a href="{{ route('promos.index') }}" class="btn-cancel text-decoration-none d-inline-block me-2">Kembali</a>
                <button type="submit" class="btn-save">Update Promo</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectCakupan = document.getElementById('jenis_cakupan');
        const fieldCategory = document.getElementById('field_category');
        const fieldProductId = document.getElementById('field_product_id');

        const productSelectInstance = new TomSelect('#product_select', {
            create: false,
            sortField: { field: "text", direction: "asc" }
        });

        function sesuaikanInput() {
            fieldCategory.style.display = 'none';
            fieldProductId.style.display = 'none';

            if (selectCakupan.value === 'category') {
                fieldCategory.style.display = 'block';
            } else if (selectCakupan.value === 'specific') {
                fieldProductId.style.display = 'block';
            }
        }
        
        selectCakupan.addEventListener('change', sesuaikanInput);
        
        // Menjalankan sekali di awal agar dropdown kategori / produk langsung muncul menyesuaikan data database lama
        sesuaikanInput(); 
    });
</script>

@endsection