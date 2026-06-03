@extends('admin.dashboard')

@section('content')

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
</style>

<div class="promo-card">

```
<div class="promo-header">
    <h2 class="promo-title text-white">
        Tambah Promo
    </h2>

    <div class="promo-subtitle">
        Buat promo baru untuk toko.
    </div>
</div>

<div class="promo-body">

    <form action="{{ route('promos.store') }}" method="POST">

        @csrf

        <div class="row">

            <div class="col-md-6 mb-4">
                <label class="form-label">
                    Nama Promo
                </label>

                <input
                    type="text"
                    name="nama_promo"
                    class="form-control modern-input">
            </div>

            <div class="col-md-6 mb-4">
                <label class="form-label">
                    Kode Promo
                </label>

                <input
                    type="text"
                    name="kode_promo"
                    class="form-control modern-input">
            </div>

            <div class="col-md-6 mb-4">
                <label class="form-label">
                    Jenis Cakupan
                </label>

                <select
                    name="jenis_cakupan"
                    class="form-select modern-input">

                    <option value="all">
                        Universal
                    </option>

                    <option value="category">
                        Per Kategori
                    </option>

                    <option value="specific">
                        Produk Spesifik
                    </option>

                </select>
            </div>

            <div class="col-md-6 mb-4">
                <label class="form-label">
                    Diskon (%)
                </label>

                <input
                    type="number"
                    name="diskon"
                    class="form-control modern-input">
            </div>

            <div class="col-md-6 mb-4">
                <label class="form-label">
                    Status Promo
                </label>

                <select
                    name="status"
                    class="form-select modern-input">

                    <option value="aktif">
                        Aktif
                    </option>

                    <option value="nonaktif">
                        Nonaktif
                    </option>

                </select>
            </div>

            <div class="col-md-6 mb-4">
                <label class="form-label">
                    Tanggal Mulai
                </label>

                <input
                    type="date"
                    name="tanggal_mulai"
                    class="form-control modern-input">
            </div>

            <div class="col-md-6 mb-4">
                <label class="form-label">
                    Tanggal Berakhir
                </label>

                <input
                    type="date"
                    name="tanggal_selesai"
                    class="form-control modern-input">
            </div>

        </div>

        <button type="submit"
                class="btn btn-primary">
            Simpan Promo
        </button>

    </form>

</div>
```

</div>

@endsection
