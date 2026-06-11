@extends('admin.dashboard')

@section('content')

<div class="mb-4">
    <a href="{{ route('customer-profiles.index') }}" class="text-decoration-none text-white bg-secondary px-3 py-2 rounded-3 d-inline-block opacity-75 hover-opacity-100">
        <i class="bi bi-arrow-left"></i> Kembali ke Daftar Customer
    </a>
</div>

<div class="mb-4">
    <h1 class="fw-bold text-white mb-1">Profil Detail Customer</h1>
    <p class="text-light opacity-50 mb-0">Informasi autentikasi lengkap dan tanggal registrasi user di platform GadgetHub.</p>
</div>

<div class="row g-4">
    <!-- KARTU IDENTITAS KIRI -->
    <div class="col-lg-4">
        <div class="profile-card-left h-100 d-flex flex-column justify-content-center align-items-center text-center">
            <div class="avatar-badge-wrapper">
                <i class="bi bi-person-badge text-info"></i>
            </div>
            <h3 class="mt-4 fw-bold text-white mb-1">{{ $customer->name }}</h3>
            <div class="role-badge">CUSTOMER GADGETHUB</div>
            
            <div class="mt-3">
                <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-50 px-3 py-2 rounded-pill fw-bold"><i class="bi bi-shield-check"></i> Akun Aktif</span>
            </div>

            <div class="join-date-text mt-4">
                <small class="text-muted d-block text-uppercase">Member Sejak</small>
                <span class="text-light opacity-75 fw-semibold">{{ $customer->created_at ? $customer->created_at->format('d M Y') : '-' }}</span>
            </div>
        </div>
    </div>

    <!-- DATA DETAIL KANAN -->
    <div class="col-lg-8">
        <div class="profile-card-right h-100 text-white">
            <h4 class="fw-bold mb-4 pb-2 border-bottom border-secondary d-flex align-items-center">
                <i class="bi bi-shield-lock-fill text-info me-2"></i> Kredensial Akun Pengguna
            </h4>

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="info-box">
                        <small class="text-light opacity-50 d-block mb-1"><i class="bi bi-person-fill me-1"></i> NAMA LENGKAP</small>
                        <span class="fs-5 fw-bold text-white">{{ $customer->name }}</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="info-box">
                        <small class="text-light opacity-50 d-block mb-1"><i class="bi bi-envelope-fill me-1"></i> ALAMAT EMAIL</small>
                        <span class="fs-5 fw-bold text-info font-monospace">{{ $customer->email }}</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="info-box">
                        <small class="text-light opacity-50 d-block mb-1"><i class="bi bi-hash me-1"></i> USER ID</small>
                        <span class="badge bg-dark px-3 py-2 border border-secondary border-opacity-50 text-light font-monospace fs-6">#GH-00{{ $customer->id }}</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="info-box">
                        <small class="text-light opacity-50 d-block mb-1"><i class="bi bi-clock-history me-1"></i> PERUBAHAN DATA TERAKHIR</small>
                        <span class="fs-6 fw-bold text-light opacity-75">{{ $customer->updated_at ? $customer->updated_at->format('d M Y, H:i') : '-' }} WIB</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-opacity-100:hover { opacity: 1 !important; }

.profile-card-left {
    background: linear-gradient(145deg, #111827, #1f2937);
    border-radius: 24px;
    padding: 50px 24px;
    border: 1px solid rgba(255, 255, 255, 0.08);
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

.avatar-badge-wrapper {
    width: 110px;
    height: 110px;
    background: rgba(56, 189, 248, 0.05);
    border: 2px dashed rgba(56, 189, 248, 0.4);
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 55px;
    box-shadow: 0 0 20px rgba(56, 189, 248, 0.1);
}

.role-badge {
    margin-top: 15px;
    background: rgba(16, 185, 129, 0.15);
    border: 1px solid rgba(16, 185, 129, 0.3);
    padding: 4px 18px;
    border-radius: 50px;
    color: #10b981;
    font-weight: 700;
    font-size: 0.85rem;
    letter-spacing: 1px;
}

.profile-card-right {
    background: rgba(30, 41, 59, 0.7);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    padding: 35px;
    border: 1px solid rgba(255, 255, 255, 0.08);
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

.info-box {
    padding: 5px;
}
</style>

@endsection