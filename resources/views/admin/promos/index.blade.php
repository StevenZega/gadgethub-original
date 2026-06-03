@extends('admin.dashboard')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold m-0 text-white">Daftar Promo Aktif</h2>
            <p class="text-penjelas small mb-0">Semua skema diskon toko dikendalikan dari halaman khusus ini.</p>
        </div>
        <a href="{{ route('promos.create') }}" class="btn-modern" style="background: linear-gradient(135deg, #a855f7, #6366f1);">
            <i class="bi bi-plus-lg me-2"></i> Buat Aturan Promo
        </a>
    </div>

    <div class="card-modern p-2 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0 text-nowrap" style="--bs-table-bg: transparent; border-color: rgba(255,255,255,0.05);">
                <thead>
                    <tr style="color: #a855f7; border-bottom: 2px solid rgba(255,255,255,0.08);">
                        <th class="ps-4 py-3.5 fs-6">Kode</th>
                        <th class="py-3.5 fs-6">Nama Event</th>
                        <th class="py-3.5 fs-6">Jenis Cakupan</th>
                        <th class="py-3.5 fs-6">Target Diskon</th>
                        <th class="py-3.5 fs-6 text-center">Besar Potongan</th>
                        <th class="py-3.5 fs-6">Masa Berlaku</th>
                        <th class="pe-4 py-3.5 fs-6 text-end col-aksi">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($promos as $promo)
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); transition: background 0.2s;">
                        <td class="ps-4 py-4 fw-bold text-purple-400 fs-5">{{ $promo->code }}</td>
                        <td class="text-white fw-medium py-4">{{ $promo->name }}</td>
                        <td class="py-4">
                            @if($promo->scope == 'all')
                                <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill fs-7">Universal (All Items)</span>
                            @elseif($promo->scope == 'category')
                                <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill fs-7">Per Kategori</span>
                            @else
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fs-7">Produk Spesifik</span>
                            @endif
                        </td>
                        <td class="text-slate-300 py-4">
                            @if($promo->scope == 'all')
                                Semua Produk Toko
                            @elseif($promo->scope == 'category')
                                Kategori: "<span class="text-white fw-semibold">{{ $promo->category }}</span>"
                            @else
                                {{ $promo->product->name ?? 'Produk Dihapus' }}
                            @endif
                        </td>
                        <td class="text-center text-emerald-400 fw-bold fs-5 py-4">{{ $promo->discount_percent }}%</td>
                        <td class="text-slate-400 fs-7 py-4">
                            <i class="bi bi-calendar3 me-1 text-purple-300"></i>
                            {{ date('d M Y', strtotime($promo->start_date)) }} <span class="text-penjelas mx-1">s/d</span> {{ date('d M Y', strtotime($promo->end_date)) }}
                        </td>
                        <td class="pe-4 py-4 text-end">
                            <div class="d-inline-flex gap-2">
                                <a href="{{ route('promos.edit', $promo->id) }}" class="btn btn-sm btn-outline-warning rounded-3 px-3 py-1.5 fw-medium">
                                    <i class="bi bi-pencil-square me-1"></i> Edit
                                </a>

                                <form action="{{ route('promos.destroy', $promo->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus promo ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-3 px-3 py-1.5 fw-medium">
                                        <i class="bi bi-trash3 me-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
    <style>
        /* 1. MENGUBAH FITUR GESER JADI ULTRA ESTETIK (MODERN DARK SCROLLBAR) */
        .table-responsive::-webkit-scrollbar {
            height: 6px; /* Bikin ketebalan scrollbar jadi super tipis (nyaman dilihat) */
            background: transparent;
        }

        .table-responsive::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.02); /* Tempat jalurnya dibuat hampir transparan */
            border-radius: 20px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, rgba(168, 85, 247, 0.4), rgba(99, 102, 241, 0.4)); /* Warna scrollbar gradasi ungu-biru transparan */
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .table-responsive::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, rgba(168, 85, 247, 0.8), rgba(99, 102, 241, 0.8)); /* Saat mouse di atasnya, warnanya menyala cerah */
        }

        /* 2. OPTIMALISASI JARAK AGAR TIDAK TERLALU MEMAKSA GESER KANAN */
        .table th, .table td {
            padding-left: 20px !important;
            padding-right: 20px !important;
        }
        
        /* Mempersingkat ukuran kolom aksi agar pas */
        .col-aksi {
            width: 150px;
        }
    </style>
@endsection