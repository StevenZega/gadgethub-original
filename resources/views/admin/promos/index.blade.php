@extends('admin.dashboard')

@section('content')

<div class="card-modern">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Daftar Promo</h3>
            <small class="fw-bold mb-1">
                Kelola semua promo yang tersedia di toko.
            </small>
        </div>

        <a href="{{ route('promos.create') }}"
           class="btn-modern">
            <i class="bi bi-plus-circle"></i>
            Tambah Promo
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>
        </div>
    @endif

    <div class="table-responsive">

        <table class="table table-dark table-hover align-middle">

            <thead>
                <tr>
                    <th>Nama Promo</th>
                    <th>Kode Promo</th>
                    <th>Diskon</th>
                    <th>Status</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Berakhir</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($promos as $promo)

                    <tr>

                        <td>
                            <strong>
                                {{ $promo->nama_promo }}
                            </strong>
                        </td>

                        <td>
                            <span class="badge bg-info text-dark">
                                {{ $promo->kode_promo }}
                            </span>
                        </td>

                        <td>
                            <span class="badge bg-primary">
                                {{ $promo->diskon }}%
                            </span>
                        </td>

                        <td>

                            @if($promo->status == 'aktif')

                                <span class="badge bg-success">
                                    Aktif
                                </span>

                            @else

                                <span class="badge bg-danger">
                                    Nonaktif
                                </span>

                            @endif

                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($promo->tanggal_mulai)->format('d M Y') }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($promo->tanggal_selesai)->format('d M Y') }}
                        </td>

                        <td>

                            <a href="{{ route('promos.edit', $promo->id) }}"
                               class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i>
                                Edit
                            </a>

                            <form action="{{ route('promos.destroy', $promo->id) }}"
                                  method="POST"
                                  class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin ingin menghapus promo ini?')">

                                    <i class="bi bi-trash"></i>
                                    Hapus

                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="text-center py-4">
                            Belum ada data promo.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


@endsection