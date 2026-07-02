@extends('admin.dashboard')

@section('content')

<div class="card-modern">
    <h3 class="mb-4">Daftar Pesanan Masuk</h3>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <table class="table table-dark align-middle">
        <thead>
            <tr>
                <th>Invoice</th>
                <th>Penerima</th>
                <th>Daftar Produk Anda</th> <th>Total Invoice</th>
                <th>Status</th>
                <th>Bukti Transfer</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
        @foreach($orders as $order)
            <tr>
                <td><span class="font-monospace fw-bold">{{ $order->invoice_number }}</span></td>
                <td>
                    <div>{{ $order->receiver_name }}</div>
                    <small class="text-white">{{ $order->phone }}</small>
                </td>
                <td>
                    <div class="d-flex flex-column gap-1">
                        @foreach($order->items as $item)
                            @if($item->product)
                                <div class="p-2 rounded bg-light/5 border border-white/5" style="background: rgba(255,255,255,0.03)">
                                    <span class="text-info fw-semibold">{{ $item->product->name }}</span> 
                                    <span class="badge bg-secondary ms-1">x{{ $item->quantity }}</span>
                                    <div class="text-white small">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </td>
                <td><span class="text-emerald fw-semibold">Rp{{ number_format($order->total, 0, ',', '.') }}</span></td>
                <td>
                    @if($order->status == 'paid')
                        <span class="badge bg-success">Paid</span>
                    @elseif($order->status == 'rejected')
                        <span class="badge bg-danger">Rejected</span>
                    @else
                        <span class="badge bg-warning text-dark">{{ ucfirst($order->status) }}</span>
                    @endif
                </td>

                <td>
                    @if($order->payment_proof)
                        <a href="{{ asset('storage/'.$order->payment_proof) }}"
                           target="_blank" class="btn btn-outline-info btn-sm">
                           <i class="bi bi-file-earmark-image"></i> Lihat Bukti
                        </a>
                    @else
                        <span class="text-muted small">Belum Upload</span>
                    @endif
                </td>

                <td>
                    @if($order->status == 'verifying' || $order->status == 'pending')
                        <form action="{{ route('admin.orders.approve', $order->id) }}"
                              method="POST"
                              class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-success btn-sm fw-semibold" onclick="return confirm('Terima pesanan ini? Stok produk Anda akan berkurang otomatis.');">
                                Terima
                            </button>
                        </form>

                        <form action="{{ route('admin.orders.reject', $order->id) }}"
                              method="POST"
                              class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-danger btn-sm fw-semibold" onclick="return confirm('Tolak pesanan ini?');">
                                Tolak
                            </button>
                        </form>
                    @else
                        <span class="text-muted small">-</span>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@endsection