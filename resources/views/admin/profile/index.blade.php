@extends('admin.dashboard')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2 class="fw-bold text-white">
            <i class="bi bi-person-circle text-primary me-2"></i>
            Profil Administrator
        </h2>

        <p class="text-secondary mb-0">
            Informasi akun administrator dan data pembayaran GadgetHub.
        </p>
    </div>

    <a href="{{ route('admin.profile.edit') }}"
       class="btn btn-primary rounded-4 px-4">

        <i class="bi bi-pencil-square me-2"></i>
        Edit Profil

    </a>

</div>

@if(session('success'))
<div class="alert alert-success rounded-4">
    {{ session('success') }}
</div>
@endif

<div class="row g-4">

    <!-- Card Profil -->
    <div class="col-lg-4">
        <div class="card-modern h-100 d-flex flex-column align-items-center text-center p-4">

            <!-- Avatar -->
            <div class="mb-4">
                @if(Auth::user()->photo)
                    <img src="{{ asset('storage/' . Auth::user()->photo) }}"
                        class="rounded-circle shadow"
                        style="width:140px;height:140px;object-fit:cover;">
                @else
                    <div class="rounded-circle bg-dark d-flex justify-content-center align-items-center shadow"
                        style="width:140px;height:140px;">
                        <i class="bi bi-person-fill text-secondary"
                            style="font-size:70px;"></i>
                    </div>
                @endif
            </div>

            <!-- Nama -->
            <h2 class="fw-bold text-white mb-2">
                {{ Auth::user()->name }}
            </h2>

            <span class="badge bg-primary px-3 py-2 rounded-pill mb-4">
                Administrator
            </span>

            <hr class="border-secondary w-100">

            <!-- Informasi -->
            <div class="w-100 text-start mt-3">
                <small class="text-secondary d-block">
                    Email
                </small>

                <h6 class="text-white mb-0">
                    {{ Auth::user()->email }}
                </h6>
            </div>

        </div>
    </div>

    <!-- Informasi -->
    <div class="col-lg-8">

        <div class="row g-4">

            <div class="col-md-6">

                <div class="card-modern h-100">

                    <small class="text-secondary">
                        Lokasi Toko
                    </small>

                    <h5 class="fw-bold text-white mt-2">

                        {{ $setting->store_location ?? '-' }}

                    </h5>

                </div>

            </div>

            <div class="col-md-6">

                <div class="card-modern h-100">

                    <small class="text-secondary">
                        Nomor Rekening
                    </small>

                    <h5 class="fw-bold text-white mt-2">

                        {{ $setting->bank_account ?? '-' }}

                    </h5>

                </div>

            </div>

            <div class="col-12">

                <div class="card-modern">

                    <small class="text-secondary">
                        QR Code Pembayaran
                    </small>

                    <div class="text-center mt-4">

                        @if($setting && $setting->qris_image)

                            <img src="{{ asset($setting->qris_image) }}"
                                 class="img-fluid rounded-4 shadow"
                                 style="max-width:280px;">

                        @else

                            <div class="py-5">

                                <i class="bi bi-qr-code text-secondary"
                                   style="font-size:90px;"></i>

                                <p class="text-secondary mt-3">
                                    QR Code belum tersedia.
                                </p>

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection