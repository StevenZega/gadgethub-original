@extends('admin.dashboard')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('promos.index') }}" class="text-purple-400 text-decoration-none small d-inline-flex align-items-center mb-2 animate-hover">
                <i class="bi bi-arrow-left me-2"></i> Kembali ke Daftar Promo
            </a>
            <h2 class="fw-bold m-0 text-white">Detail Aturan Promo</h2>
            <p class="text-penjelas small mb-0">Informasi lengkap mengenai skema diskon yang sedang berjalan.</p>
        </div>
        <div>
            <a href="{{ route('promos.edit', $promo->id) }}" class="btn btn-sm btn-outline-warning rounded-3 px-4 py-2 fw-medium border-opacity-50">
                <i class="bi bi-pencil-square me-1"></i> Edit Promo
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card-modern text-center p-4 h-100 d-flex flex-column justify-content-center align-items-center" style="background: linear-gradient(145deg, #1e1b4b, #0f172a); border-radius: 16px; border: 1px solid rgba(255,255,255,0.05);">
                <div class="bg-purple-500 bg-opacity-10 p-3 rounded-circle mb-3 border border-purple-500 border-opacity-25 shadow-sm">
                    <i class="bi bi-ticket-perforated text-purple-400" style="font-size: 2.5rem;"></i>
                </div>
                
                <h2 class="text-white fw-bold mt-1 mb-2 fs-4">{{ $promo->name }}</h2>
                
                <div class="px-3 py-1 mb-4 rounded-3 text-purple-300 fs-7 border border-purple-500 border-opacity-35 font-monospace tracking-wider" style="background: rgba(168, 85, 247, 0.08);">
                    CODE: {{ $promo->code }}
                </div>
                
                <div class="badge bg-emerald-500 bg-opacity-10 text-emerald-400 px-4 py-2.5 rounded-pill fs-5 fw-bold border border-emerald-500 border-opacity-25 shadow-sm">
                    Potongan {{ $promo->discount_percent }}%
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card-modern p-4 h-100" style="background: #1e293b; border-radius: 16px; border: 1px solid rgba(255,255,255,0.05);">
                <h4 class="text-white fw-bold mb-4 d-inline-flex align-items-center">
                    <i class="bi bi-gear-fill text-purple-400 me-2 animate-spin-slow"></i> Parameter Konfigurasi Aturan
                </h4>
                
                <div class="table-responsive">
                    <table class="table table-dark align-middle mb-0" style="--bs-table-bg: transparent;">
                        <tbody>
                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                <td class="text-penjelas py-3" style="width: 200px;">Jenis Cakupan</td>
                                <td class="py-3">: 
                                    @if($promo->scope == 'all')
                                        <span class="badge bg-info bg-opacity-10 text-info px-3 py-1.5 rounded-pill ms-2 border border-info border-opacity-10">Universal (All Items)</span>
                                    @elseif($promo->scope == 'category')
                                        <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-1.5 rounded-pill ms-2 border border-warning border-opacity-10">Per Kategori</span>
                                    @else
                                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1.5 rounded-pill ms-2 border border-primary border-opacity-10">Produk Spesifik</span>
                                    @endif
                                </td>
                            </tr>
                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                <td class="text-penjelas py-3">Target Objek Kategori / Produk</td>
                                <td class="py-3 text-white fw-semibold">: 
                                    <span class="ms-2">
                                        @if($promo->scope == 'all')
                                            Semua Katalog Inventaris Gadget
                                        @elseif($promo->scope == 'category')
                                            Kategori "{{ $promo->category }}"
                                        @else
                                            {{ $promo->product->name ?? 'Produk Tidak Ditemukan' }}
                                        @endif
                                    </span>
                                </td>
                            </tr>
                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                <td class="text-penjelas py-3">Tanggal Mulai</td>
                                <td class="py-3 text-slate-300">: 
                                    <span class="ms-2"><i class="bi bi-calendar-check text-success me-1"></i> {{ date('d F Y', strtotime($promo->start_date)) }}</span>
                                </td>
                            </tr>
                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                <td class="text-penjelas py-3">Tanggal Kadaluarsa</td>
                                <td class="py-3 text-slate-300">: 
                                    <span class="ms-2"><i class="bi bi-calendar-x text-danger me-1"></i> {{ date('d F Y', strtotime($promo->end_date)) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-penjelas py-3">Status Validitas</td>
                                <td class="py-3">: 
                                    @php
                                        $hariIni = now()->startOfDay();
                                        $mulai = \Carbon\Carbon::parse($promo->start_date)->startOfDay();
                                        $selesai = \Carbon\Carbon::parse($promo->end_date)->endOfDay();
                                    @endphp
                                    @if($hariIni->between($mulai, $selesai))
                                        <span class="badge bg-success px-3 py-1.5 rounded-pill ms-2 shadow-sm"><i class="bi bi-check-circle-fill me-1"></i> Aktif Berjalan</span>
                                    @elseif($hariIni->lessThan($mulai))
                                        <span class="badge bg-secondary px-3 py-1.5 rounded-pill ms-2 shadow-sm"><i class="bi bi-clock-history me-1"></i> Menunggu Jadwal</span>
                                    @else
                                        <span class="badge bg-danger px-3 py-1.5 rounded-pill ms-2 shadow-sm"><i class="bi bi-exclamation-triangle-fill me-1"></i> Sudah Expired</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .animate-hover { transition: all 0.2s ease; }
    .animate-hover:hover { color: #c084fc !important; transform: translateX(-3px); }
    @keyframes spin-slow { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    .animate-spin-slow { animation: spin-slow 8s linear infinite; }
</style>
@endsection