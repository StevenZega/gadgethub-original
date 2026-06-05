@extends('admin.dashboard')

@section('content')

<div class="mb-4">
    <a href="{{ route('promos.index') }}" class="text-decoration-none text-white bg-secondary px-3 py-2 rounded-3 d-inline-block">
        <i class="bi bi-arrow-left"></i> Kembali ke Daftar Promo
    </a>
</div>

<div class="d-flex justify-content-between align-items-start flex-wrap mb-4">
    <div>
        <h1 class="fw-bold text-white mb-1">Detail Promo</h1>
        <p class="text-light opacity-75">
            Informasi lengkap mengenai promo yang sedang tersedia.
        </p>
    </div>

    <a href="{{ route('promos.edit', $promo->id) }}" class="btn btn-outline-warning px-4 py-2 rounded-4">
        <i class="bi bi-pencil-square"></i> Edit Promo
    </a>
</div>

<div class="row g-4">

    {{-- KARTU KIRI --}}
    <div class="col-lg-4">
        <div class="promo-card-left h-100">
            <div class="text-center">
                <div class="promo-icon">
                    <i class="bi bi-ticket-perforated"></i>
                </div>
                <h3 class="mt-4 fw-bold text-white">{{ $promo->name }}</h3>
                <div class="promo-code">{{ $promo->code }}</div>
                <div class="promo-discount">{{ $promo->discount_percent }}%</div>
            </div>
        </div>
    </div>

    {{-- KARTU KANAN --}}
    <div class="col-lg-8">
        <div class="promo-card-right text-white">
            <h2 class="fw-bold mb-4">
                <i class="bi bi-gear-fill"></i> Detail Konfigurasi Promo
            </h2>

            <div class="detail-row">
                <span>Nama Promo</span>
                <strong>{{ $promo->name }}</strong>
            </div>

            <div class="detail-row">
                <span>Kode Promo</span>
                <strong>{{ $promo->code }}</strong>
            </div>

            <div class="detail-row">
                <span>Jenis Cakupan</span>
                @if($promo->scope == 'all')
                    <span class="badge bg-info px-3 py-2 rounded-pill">Universal</span>
                @elseif($promo->scope == 'category')
                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Per Kategori</span>
                @else
                    <span class="badge bg-primary px-3 py-2 rounded-pill">Produk Spesifik</span>
                @endif
            </div>

            <div class="detail-row">
                <span>Diskon</span>
                <strong>{{ $promo->discount_percent }}%</strong>
            </div>

            <div class="detail-row">
                <span>Tanggal Mulai</span>
                <strong>{{ \Carbon\Carbon::parse($promo->start_date)->format('d F Y') }}</strong>
            </div>

            <div class="detail-row">
                <span>Tanggal Berakhir</span>
                <strong>{{ \Carbon\Carbon::parse($promo->end_date)->format('d F Y') }}</strong>
            </div>

            <div class="detail-row">
                <span>Status Promo</span>
                @if($promo->is_active)
                    <span class="badge bg-success px-3 py-2 rounded-pill">Aktif</span>
                @else
                    <span class="badge bg-danger px-3 py-2 rounded-pill">Nonaktif</span>
                @endif
            </div>
        </div>
    </div>

</div>

<style>
.promo-card-left{
    background: linear-gradient(180deg,#221b5a,#0c173c);
    border-radius:28px;
    padding:50px 30px;
    border:1px solid rgba(255,255,255,.08);
}
.promo-card-right{
    background: rgba(255,255,255,.05);
    backdrop-filter: blur(20px);
    border-radius:28px;
    padding:35px;
    border:1px solid rgba(255,255,255,.08);
}
.promo-icon{
    width:120px;
    height:120px;
    margin:auto;
    border:2px solid rgba(255,255,255,.7);
    border-radius:50%;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:50px;
    color:white;
}
.promo-code{
    display:inline-block;
    margin-top:25px;
    border:1px solid rgba(255,255,255,.6);
    border-radius:14px;
    padding:10px 25px;
    font-weight:700;
    color:white;
}
.promo-discount{
    margin-top:25px;
    border:1px solid rgba(255,255,255,.7);
    border-radius:40px;
    padding:12px 30px;
    font-size:28px;
    font-weight:700;
    color:white;
}
.detail-row{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:20px 0;
    border-bottom:1px solid rgba(255,255,255,.08);
}
.detail-row span, .detail-row strong{
    font-size:18px;
}
</style>

@endsection