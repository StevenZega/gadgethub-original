@extends('admin.dashboard')

@section('content')

<div class="mb-4">
    <a href="{{ route('promos.index') }}" class="text-decoration-none text-white bg-secondary px-3 py-2 rounded-3 d-inline-block opacity-75 hover-opacity-100">
        <i class="bi bi-arrow-left"></i> Kembali ke Daftar Promo
    </a>
</div>

<div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
    <div>
        <h1 class="fw-bold text-white mb-1">Detail Konfigurasi Promo</h1>
        <p class="text-light opacity-50 mb-0">Pantau batasan kuota, cakupan target, dan masa aktif promo.</p>
    </div>
    <a href="{{ route('promos.edit', $promo->id) }}" class="btn btn-warning px-4 py-2 rounded-3 fw-bold text-dark">
        <i class="bi bi-pencil-square"></i> Edit Promo
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="promo-card-left h-100 d-flex flex-column justify-content-center align-items-center text-center">
            <div class="promo-icon-wrapper">
                <i class="bi bi-ticket-perforated-fill"></i>
            </div>
            <h3 class="mt-4 fw-bold text-white mb-1">{{ $promo->name }}</h3>
            <div class="promo-code-badge">{{ $promo->code }}</div>
            <div class="promo-discount-display">{{ $promo->discount_percent }}%</div>
            <small class="text-light opacity-50 text-uppercase tracking-wider">Potongan Harga</small>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="promo-card-right h-100 text-white">
            <h4 class="fw-bold mb-4 pb-2 border-bottom border-secondary d-flex align-items-center">
                <i class="bi bi-info-circle-fill text-info me-2"></i> Informasi Aturan Promo
            </h4>

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="info-box">
                        <small class="text-light opacity-50 d-block mb-1"><i class="bi bi-eye-fill me-1"></i> JENIS CAKUPAN</small>
                        @if($promo->scope === 'all')
                            <span class="badge bg-info px-3 py-2 rounded-pill fw-bold">Universal (Semua Produk)</span>
                        @elseif($promo->scope === 'category')
                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold">Per Kategori</span>
                        @elseif($promo->scope === 'specific')
                            <span class="badge bg-primary px-3 py-2 rounded-pill fw-bold">Produk Spesifik</span>
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="info-box">
                        <small class="text-light opacity-50 d-block mb-1"><i class="bi bi-target me-1"></i> TARGET SASARAN</small>
                        <span class="fs-5 fw-bold text-white">
                            @if($promo->scope === 'all')
                                Seluruh Katalog Toko
                            @elseif($promo->scope === 'category')
                                Kategori <span class="text-warning">{{ $promo->category }}</span>
                            @elseif($promo->scope === 'specific')
                                <span class="text-info">{{ $promo->product ? $promo->product->name : 'Produk ID: '.$promo->product_id }}</span>
                            @endif
                        </span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="info-box">
                        <small class="text-light opacity-50 d-block mb-1"><i class="bi bi-calculator-fill me-1"></i> SISA KUOTA PROMO</small>
                        <span class="fs-4 fw-bold text-success">{{ $promo->quota }} <span class="fs-6 text-white opacity-75">Kali Penggunaan</span></span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="info-box">
                        <small class="text-light opacity-50 d-block mb-1"><i class="bi bi-toggle-on me-1"></i> STATUS SAAT INI</small>
                        <div class="mt-1">
                            @if($promo->is_active == 1)
                                <span class="badge bg-success px-4 py-2 rounded-pill fs-6"><i class="bi bi-check-circle-fill me-1"></i> Aktif</span>
                            @else
                                <span class="badge bg-danger px-4 py-2 rounded-pill fs-6"><i class="bi bi-x-circle-fill me-1"></i> Nonaktif</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="info-box bg-dark-smooth p-3 rounded-4 border border-secondary border-opacity-20">
                        <small class="text-light opacity-50 d-block mb-2"><i class="bi bi-calendar3 me-1"></i> MASA BERLAKU OPERASIONAL</small>
                        <div class="d-flex align-items-center flex-wrap gap-3">
                            <div class="date-node">
                                <small class="d-block text-muted text-uppercase">Mulai</small>
                                <strong class="text-white fs-6">{{ $promo->start_date ? \Carbon\Carbon::parse($promo->start_date)->format('d M Y - H:i') : '-' }} WIB</strong>
                            </div>
                            <div class="text-warning fs-4 px-2"><i class="bi bi-arrow-right"></i></div>
                            <div class="date-node">
                                <small class="d-block text-muted text-uppercase">Berakhir</small>
                                <strong class="text-danger fs-6">{{ $promo->end_date ? \Carbon\Carbon::parse($promo->end_date)->format('d M Y - H:i') : '-' }} WIB</strong>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
.hover-opacity-100:hover { opacity: 1 !important; }
.bg-dark-smooth { background: rgba(0, 0, 0, 0.2); }

.promo-card-left {
    background: linear-gradient(145deg, #1e1b4b, #0f172a);
    border-radius: 24px;
    padding: 40px 24px;
    border: 1px solid rgba(255, 255, 255, 0.08);
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

.promo-icon-wrapper {
    width: 90px;
    height: 90px;
    background: rgba(255, 255, 255, 0.05);
    border: 2px dashed rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 42px;
    color: #60a5fa;
}

.promo-code-badge {
    margin-top: 15px;
    background: rgba(96, 165, 250, 0.15);
    border: 1px solid rgba(96, 165, 250, 0.3);
    padding: 6px 20px;
    border-radius: 12px;
    color: #38bdf8;
    font-weight: 700;
    letter-spacing: 1.5px;
    font-family: monospace;
    font-size: 1.1rem;
}

.promo-discount-display {
    font-size: 72px;
    font-weight: 900;
    color: #4ade80;
    margin-top: 15px;
    line-height: 1;
    text-shadow: 0 0 20px rgba(74, 222, 128, 0.2);
}

.promo-card-right {
    background: rgba(30, 41, 59, 0.7);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    padding: 35px;
    border: 1px solid rgba(255, 255, 255, 0.08);
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

.info-box {
    padding: 10px 5px;
}

.date-node {
    background: rgba(255, 255, 255, 0.03);
    padding: 10px 20px;
    border-radius: 12px;
    border-left: 3px solid #3b82f6;
    min-width: 200px;
}
</style>

@endsection