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

    .modern-input::placeholder{
        color:#94a3b8;
    }

    .input-group-text{
        background: rgba(255,255,255,0.06);
        border:1px solid rgba(255,255,255,0.08);
        color:#60a5fa;
        border-radius:16px 0 0 16px;
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

    .btn-save:hover{
        transform:translateY(-2px);
        color:white;
    }

    .btn-cancel{
        border:1px solid rgba(255,255,255,0.15);
        color:#cbd5e1;
        padding:12px 24px;
        border-radius:14px;
    }

    .btn-cancel:hover{
        background:rgba(255,255,255,0.05);
        color:white;
    }
</style>

<div class="promo-card">

    <div class="promo-header">
        <div>
            <h2 class="promo-title">
                <i class="bi bi-pencil-square text-warning"></i>
                Edit Promo
            </h2>

            <div class="promo-subtitle">
                Perbarui data promo yang sudah ada.
            </div>
        </div>
    </div>

    <div class="promo-body">

        <form action="{{ route('promos.update', $promo->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-md-6 mb-4">
                    <label class="form-label">
                        Nama Promo
                    </label>

                    <input
                        type="text"
                        name="nama_promo"
                        class="form-control modern-input"
                        value="{{ $promo->nama_promo }}">
                </div>

                <div class="col-md-6 mb-4">
                    <label class="form-label">
                        Kode Promo
                    </label>

                    <input
                        type="text"
                        name="kode_promo"
                        class="form-control modern-input"
                        value="{{ $promo->kode_promo }}">
                </div>

                <div class="col-md-6 mb-4">
                    <label class="form-label">
                        Diskon (%)
                    </label>

                    <input
                        type="number"
                        name="diskon"
                        class="form-control modern-input"
                        value="{{ $promo->diskon }}">
                </div>

                <div class="col-md-6 mb-4">
                    <label class="form-label">
                        Status Promo
                    </label>

                    <select
                        name="status"
                        class="form-select modern-input">

                        <option value="aktif"
                            {{ $promo->status == 'aktif' ? 'selected' : '' }}>
                            Aktif
                        </option>

                        <option value="nonaktif"
                            {{ $promo->status == 'nonaktif' ? 'selected' : '' }}>
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
                        class="form-control modern-input"
                        value="{{ $promo->tanggal_mulai }}">
                </div>

                <div class="col-md-6 mb-4">
                    <label class="form-label">
                        Tanggal Selesai
                    </label>

                    <input
                        type="date"
                        name="tanggal_selesai"
                        class="form-control modern-input"
                        value="{{ $promo->tanggal_selesai }}">
                </div>

            </div>

            <div class="mt-4">

                <a href="{{ route('promos.index') }}"
                   class="btn btn-secondary">
                    Kembali
                </a>

                <button type="submit"
                        class="btn btn-primary">
                    Update Promo
                </button>

            </div>

        </form>

    </div>

</div>

@endsection