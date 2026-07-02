@extends('admin.dashboard')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold m-0 text-white">Notifikasi</h3>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 text-success rounded-3 mb-4 d-flex align-items-center gap-2" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.15) !important;">
            <i class="bi bi-check-circle-fill"></i>
            <span class="small fw-semibold">{{ session('success') }}</span>
        </div>
    @endif

    <div class="card-modern p-2 overflow-hidden" style="background: #1e293b; border: 1px solid rgba(255,255,255,0.05); border-radius: 16px;">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0 text-nowrap" style="--bs-table-bg: transparent; border-color: rgba(255,255,255,0.05);">
                <thead>
                    <tr style="color: #a855f7; border-bottom: 2px solid rgba(255,255,255,0.08);">
                        <th class="ps-4 py-3.5 fs-6">Produk</th>
                        <th class="py-3.5 fs-6">Pesan</th>
                        <th class="py-3.5 fs-6">Waktu Masuk</th>
                        <th class="pe-4 py-3.5 fs-6 text-center" style="width: 180px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($warnings as $warning)
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); transition: background 0.2s; {{ $warning->is_read ? 'opacity: 0.65;' : '' }}"
                        onmouseover="this.style.background='rgba(255,255,255,0.02)'" 
                        onmouseout="this.style.background='transparent'">
                        
                        <td class="ps-4 py-4">
                            <div class="d-flex align-items-center">
                                @if($warning->product && $warning->product->image)
                                    <img src="{{ asset('storage/' . $warning->product->image) }}" alt="" style="width: 50px; height: 50px; object-fit: cover;" class="rounded-3 border border-secondary border-opacity-25 me-3">
                                @else
                                    <div class="bg-secondary bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; border: 1px dashed rgba(255,255,255,0.15);">
                                        <i class="bi bi-box-seam text-white fs-4"></i>
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-bold text-white fs-5">{{ $warning->product->name ?? '[Produk Telah Dihapus]' }}</div>
                                    <span class="text-white small"><i class="bi bi-tag-fill me-1"></i>{{ $warning->product->brand ?? '-' }}</span>
                                </div>
                            </div>
                        </td>

                        <td class="py-4 text-wrap" style="max-width: 350px;">
                            <div class="text-slate-200 small p-3 rounded-3 font-monospace italic" style="background: rgba(15, 23, 42, 0.4); border: 1px solid rgba(255,255,255,0.03); color: #cbd5e1 !important; line-height: 1.5;">
                                "{{ $warning->message }}"
                            </div>
                        </td>

                        <td class="text-white small py-4">
                            <i class="bi bi-clock-history me-1"></i> {{ $warning->created_at->diffForHumans() }}
                        </td>

                        <td class="pe-4 py-4 text-center">
                            @if(!$warning->is_read)
                                <form action="{{ route('admin.notifications.read', $warning->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-outline-warning rounded-3 px-3 py-1.5 fw-medium border-opacity-40 d-inline-flex align-items-center gap-1">
                                        <i class="bi bi-envelope-open-fill"></i> Tandai Dibaca
                                    </button>
                                </form>
                            @else
                                <span class="badge bg-secondary bg-opacity-10 text-white px-3 py-2 rounded-pill border border-secondary border-opacity-10 font-medium small">
                                    <i class="bi bi-check2-all me-1"></i> Selesai Dibaca
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-white fs-6">
                            <i class="bi bi-shield-check text-secondary d-block mb-2" style="font-size: 2.5rem;"></i>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection