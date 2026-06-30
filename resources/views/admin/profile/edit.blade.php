@extends('admin.dashboard')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2 class="fw-bold text-white">
            <i class="bi bi-pencil-square text-primary me-2"></i>
            Edit Profil Administrator
        </h2>

        <p class="text-secondary mb-0">
            Perbarui informasi administrator dan informasi pembayaran toko.
        </p>
    </div>

    <a href="{{ route('admin.profile') }}" class="btn btn-outline-light rounded-4 px-4">
        <i class="bi bi-arrow-left me-2"></i>
        Kembali
    </a>

</div>

@if($errors->any())

<div class="alert alert-danger rounded-4">

    <ul class="mb-0">

        @foreach($errors->all() as $error)

            <li>{{ $error }}</li>

        @endforeach

    </ul>

</div>

@endif

<div class="card-modern">

<form action="{{ route('admin.profile.update') }}"
      method="POST"
      enctype="multipart/form-data">

@csrf
@method('PUT')

<div class="row">

    <div class="col-12 text-center mb-4">

        @if(Auth::user()->photo)

            <img
                id="previewPhoto"
                src="{{ asset('storage/' . Auth::user()->photo) }}"
                class="rounded-circle shadow"
                style="width:150px;height:150px;object-fit:cover;">

        @else

            <div
                id="photoPlaceholder"
                class="rounded-circle bg-dark d-inline-flex justify-content-center align-items-center shadow"
                style="width:150px;height:150px;">

                <i class="bi bi-person-fill text-secondary"
                style="font-size:70px;"></i>

            </div>

            <img
                id="previewPhoto"
                style="display:none;width:150px;height:150px;object-fit:cover;"
                class="rounded-circle shadow">

        @endif

    </div>

    <div class="col-12 mb-4">

        <label class="form-label text-white">
            Foto Profil
        </label>

        <input
            type="file"
            name="photo"
            class="form-control"
            accept="image/*"
            onchange="previewPhoto(event)">

    </div>

    <div class="col-md-6 mb-4">

        <label class="form-label text-white fw-semibold">
            Nama Administrator
        </label>

        <input
            type="text"
            name="name"
            class="form-control"
            value="{{ old('name', Auth::user()->name) }}"
            required>

    </div>

    <div class="col-md-6 mb-4">

        <label class="form-label text-white fw-semibold">
            Email Administrator
        </label>

        <input
            type="email"
            name="email"
            class="form-control"
            value="{{ old('email', Auth::user()->email) }}"
            required>

    </div>

    <div class="col-12 mb-4">

        <label class="form-label text-white fw-semibold">
            Lokasi Toko Onsite
        </label>

        <textarea
            name="store_location"
            rows="3"
            class="form-control">{{ old('store_location',$setting->store_location ?? '') }}</textarea>

    </div>

    <div class="col-12 mb-4">

        <label class="form-label text-white fw-semibold">
            Nomor Rekening
        </label>

        <input
            type="text"
            name="bank_account"
            class="form-control"
            value="{{ old('bank_account',$setting->bank_account ?? '') }}">

    </div>

    <div class="col-12 mb-4">

        <label class="form-label text-white fw-semibold">
            Upload QRIS
        </label>

        <input
            type="file"
            name="qris_image"
            class="form-control"
            accept="image/*"
            onchange="previewQR(event)">

        <small class="text-secondary">
            Format JPG / PNG.
        </small>

    </div>

    <div class="col-12">

        <label class="form-label text-white fw-semibold">
            Preview QRIS
        </label>

        <div class="card bg-dark border-secondary rounded-4 p-4 text-center">

            @if(isset($setting) && $setting->qris_image)

                <img
                    id="preview"
                    src="{{ asset($setting->qris_image) }}"
                    class="img-fluid rounded"
                    style="max-width:250px;">

            @else

                <img
                    id="preview"
                    src=""
                    style="display:none;max-width:250px;"
                    class="img-fluid rounded">

                <div id="placeholder">

                    <i class="bi bi-qr-code text-secondary"
                       style="font-size:80px;"></i>

                    <p class="text-secondary mt-3">
                        Belum ada QR Code
                    </p>

                </div>

            @endif

        </div>

    </div>

</div>

<hr class="border-secondary my-4">

<div class="text-end">

    <a href="{{ route('admin.profile') }}"
       class="btn btn-secondary rounded-4 px-4">

        Batal

    </a>

    <button
        class="btn btn-primary rounded-4 px-5">

        <i class="bi bi-check-circle me-2"></i>

        Simpan Perubahan

    </button>

</div>

</form>

</div>

<script>

function previewQR(event){

    const preview=document.getElementById('preview');

    const placeholder=document.getElementById('placeholder');

    preview.src=URL.createObjectURL(event.target.files[0]);

    preview.style.display='block';

    if(placeholder){
        placeholder.style.display='none';
    }

}

function previewPhoto(event){

    const preview = document.getElementById('previewPhoto');

    preview.src = URL.createObjectURL(event.target.files[0]);

    preview.style.display = 'block';

    const placeholder =
        document.getElementById('photoPlaceholder');

    if(placeholder){

        placeholder.style.display='none';

    }

}

</script>

@endsection