@extends('admin.dashboard')

@section('content')
<div class="container">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <a href="{{ route('products.index') }}" class="btn-modern btn-sm py-2 px-3 fs-7 text-decoration-none d-inline-flex align-items-center gap-1" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px); color: #fff;">
            <i class="bi bi-arrow-left-short fs-5 m-0"></i> Kembali ke List
        </a>
        <div class="d-flex gap-2">
            <a href="{{ route('products.edit', $product->id) }}" class="btn-modern btn-sm py-2 px-3 fs-7 text-decoration-none d-inline-flex align-items-center gap-2" style="background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.3); color: #fbbf24; border-radius: 12px;">
                <i class="bi bi-pencil-square"></i> Edit Produk
            </a>
            {{-- Button Delete dengan SweetAlert2 dari versi branch --}}
            <form id="delete-form-{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" method="POST" class="m-0">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-danger btn-sm py-2 px-3 fs-7 d-inline-flex align-items-center" style="border-radius: 12px;" onclick="confirmDelete({{ $product->id }})">
                    <i class="bi bi-trash me-1"></i> Delete
                </button>
            </form>
        </div>
    </div>

    <div class="card-modern text-white shadow-lg" style="background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.05); border-radius: 24px; padding: 2.5rem;">
        
        <div class="row">
            {{-- Kolom Kiri: Gambar & Deskripsi --}}
            <div class="col-md-5 pe-md-4 mb-4 mb-md-0">
                <div class="text-center d-flex align-items-center justify-content-center position-relative mb-4" style="background: rgba(15, 23, 42, 0.5); border-radius: 20px; border: 1px solid rgba(255,255,255,0.05); min-height: 380px; padding: 1.5rem;">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded-4" alt="{{ $product->name }}" style="max-height: 340px; object-fit: contain; width: 100%; filter: drop-shadow(0 10px 20px rgba(0,0,0,0.3));">
                    @else
                        <div class="text-muted">
                            <i class="bi bi-image fs-1 d-block mb-2 opacity-30"></i> Tidak Ada Gambar
                        </div>
                    @endif
                </div>

                <div class="p-4 rounded-4" style="background: rgba(15, 23, 42, 0.3); border: 1px solid rgba(255,255,255,0.03);">
                    <h5 class="custom-header-label mb-2"><i class="bi bi-justify-left text-secondary"></i> Deskripsi Produk</h5>
                    <p class="text-slate-300 lh-base mb-0" style="font-size: 0.95rem; white-space: pre-line; opacity: 0.85;">{{ $product->description ?? 'Tidak ada deskripsi.' }}</p>
                </div>
            </div>

            {{-- Kolom Kanan: Detail Spesifikasi & Harga --}}
            <div class="col-md-7 ps-md-4 d-flex flex-column justify-content-between">
                <div>
                    <div class="mb-3">
                        <span class="badge px-3 py-2 fs-7 mb-2 fw-semibold" style="background: rgba(139, 92, 246, 0.2); color: #c084fc; border: 1px solid rgba(139, 92, 246, 0.3); border-radius: 30px; letter-spacing: 0.05em;">
                            <i class="bi bi-tags-fill me-1"></i> {{ $product->category }}
                        </span>
                        
                        {{-- Logika Status Stok dari branch b8abad4 --}}
                        @if($product->stock <= 0)
                            <span class="badge bg-danger px-3 py-2 fs-7 mb-2 fw-semibold ms-2" style="border-radius: 30px;">Habis</span>
                        @elseif($product->stock <= 5)
                            <span class="badge bg-warning text-dark px-3 py-2 fs-7 mb-2 fw-semibold ms-2" style="border-radius: 30px;">Hampir Habis</span>
                        @else
                            <span class="badge bg-success px-3 py-2 fs-7 mb-2 fw-semibold ms-2" style="border-radius: 30px;">Tersedia</span>
                        @endif

                        <h2 class="fw-bold text-white mb-1" style="letter-spacing: -0.02em; font-size: 2rem;">{{ $product->name }}</h2>
                        <p class="text-secondary mb-0">Merek: <span class="text-white fw-bold">{{ $product->brand }}</span></p>
                    </div>

                    <hr class="border-secondary opacity-20 my-3">

                    <div class="mb-4">
                        <h5 class="custom-header-label mb-3"><i class="bi bi-cpu text-info"></i> Lembar Spesifikasi Teknis</h5>
                        
                        {{-- Pengecekan Kategori Laptop (Lebih Aman) --}}
                        @if(Str::lower($product->category) == 'laptop')
                            <div class="row g-3">
                                <div class="col-6 col-sm-4">
                                    <div class="spec-box-custom">
                                        <i class="bi bi-windows text-primary"></i>
                                        <small>Sistem Operasi</small>
                                        <span>{{ $product->os ?? '-' }}</span>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-4">
                                    <div class="spec-box-custom">
                                        <i class="bi bi-memory text-warning"></i>
                                        <small>Kapasitas RAM</small>
                                        <span>{{ $product->ram ? $product->ram . ' GB' : '-' }}</span>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-4">
                                    <div class="spec-box-custom">
                                        <i class="bi bi-hdd-rack text-success"></i>
                                        <small>Penyimpanan</small>
                                        <span>{{ $product->storage ? $product->storage . ' GB' : '-' }}</span>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-6">
                                    <div class="spec-box-custom">
                                        <i class="bi bi-cpu-fill text-info"></i>
                                        <small>Tipe Processor</small>
                                        <span>{{ $product->processor ?? '-' }}</span>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="spec-box-custom">
                                        <i class="bi bi-gpu-card text-danger"></i>
                                        <small>Kartu Grafis (VGA)</small>
                                        <span>{{ $product->vga ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Pengecekan Kategori Handphone / Smartphone / Hape --}}
                        @if(Str::lower($product->category) == 'handphone' || Str::lower($product->category) == 'smartphone' || Str::lower($product->category) == 'hape')
                            <div class="row g-3">
                                <div class="col-6 col-sm-4">
                                    <div class="spec-box-custom">
                                        <i class="bi bi-android2 text-success"></i>
                                        <small>Sistem Operasi</small>
                                        <span>{{ $product->os ?? '-' }}</span>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-4">
                                    <div class="spec-box-custom">
                                        <i class="bi bi-memory text-warning"></i>
                                        <small>Kapasitas RAM</small>
                                        <span>{{ $product->ram ? $product->ram . ' GB' : '-' }}</span>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-4">
                                    <div class="spec-box-custom">
                                        <i class="bi bi-device-hdd text-info"></i>
                                        <small>Internal Storage</small>
                                        <span>{{ $product->storage ? $product->storage . ' GB' : '-' }}</span>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-6">
                                    <div class="spec-box-custom">
                                        <i class="bi bi-cpu-fill text-info"></i>
                                        <small>Chipset Processor</small>
                                        <span>{{ $product->processor ?? '-' }}</span>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-6">
                                    <div class="spec-box-custom">
                                        <i class="bi bi-camera-fill text-danger"></i>
                                        <small>Kamera Belakang</small>
                                        <span>{{ $product->rear_camera ?? '-' }}</span>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-6">
                                    <div class="spec-box-custom">
                                        <i class="bi bi-battery-charging text-warning"></i>
                                        <small>Kapasitas Baterai</small>
                                        <span>{{ $product->battery_capacity ? $product->battery_capacity . ' mAh' : '-' }}</span>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-6">
                                    <div class="spec-box-custom">
                                        <i class="bi bi-fullscreen text-light"></i>
                                        <small>Bentang Layar</small>
                                        <span>{{ $product->screen_size ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row g-3 pt-3 border-top border-secondary border-opacity-20 mt-4">
                    <div class="col-sm-6">
                        <div class="p-3 rounded-4" style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.08);">
                            <small class="text-secondary d-block text-uppercase fw-bold small tracking-wider mb-1">Harga Jual</small>
                            <div class="fs-3 fw-bold text-white">Rp {{ number_format($product->price ?? 0, 0, ',', '.') }}</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 rounded-4" style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.08);">
                            <small class="text-secondary d-block text-uppercase fw-bold small tracking-wider mb-1">Stok Tersedia</small>
                            <div class="fs-3 fw-bold text-white">{{ $product->stock ?? 0 }} <span class="fs-6 text-white fw-normal">Unit</span></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    /* Desain Judul Section Kecil Atas */
    .custom-header-label { 
        font-weight: 700 !important; 
        font-size: 0.8rem !important; 
        color: #94a3b8 !important; 
        text-transform: uppercase !important; 
        letter-spacing: 0.08em !important; 
    }
    
    .text-slate-300 { color: #cbd5e1 !important; }

    /* Komponen Card Kecil Spesifikasi Grid */
    .spec-box-custom {
        background: rgba(15, 23, 42, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 14px;
        padding: 0.75rem 1rem;
        display: flex;
        flex-direction: column;
        height: 100%;
        transition: all 0.2s ease;
    }
    .spec-box-custom:hover {
        background: rgba(15, 23, 42, 0.6);
        border-color: rgba(255, 255, 255, 0.1);
    }
    .spec-box-custom i {
        font-size: 1.25rem;
        margin-bottom: 0.25rem;
    }
    .spec-box-custom small {
        font-size: 0.7rem;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.02em;
        margin-bottom: 0.15rem;
    }
    .spec-box-custom span {
        font-size: 0.9rem;
        font-weight: 600;
        color: #ffffff;
    }
</style>
@endsection