@extends('admin.dashboard')

@section('content')
<div class="card-modern">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Manajemen Promo</h3>
        <button class="btn-modern">
            <i class="bi bi-plus-circle"></i> Tambah Promo
        </button>
    </div>

    <table class="table table-dark table-hover">
        <thead>
            <tr>
                <th>Nama Promo</th>
                <th>Diskon</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Berakhir</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Promo Akhir Tahun</td>
                <td>20%</td>
                <td>01-12-2025</td>
                <td>31-12-2025</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection