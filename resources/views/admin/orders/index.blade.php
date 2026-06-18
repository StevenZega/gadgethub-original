@extends('admin.dashboard')

@section('content')

<div class="card-modern">
    <h3 class="mb-4">Daftar Pesanan</h3>

    <table class="table table-dark">
        <thead>
            <tr>
                <th>Invoice</th>
                <th>Penerima</th>
                <th>Total</th>
                <th>Status</th>
                <th>Bukti Transfer</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{ $order->invoice_number }}</td>
                <td>{{ $order->receiver_name }}</td>
                <td>Rp {{ number_format($order->total,0,',','.') }}</td>
                <td>{{ $order->status }}</td>

                <td>
                    @if($order->payment_proof)
                        <a href="{{ asset('storage/'.$order->payment_proof) }}"
                           target="_blank">
                           Lihat Bukti
                        </a>
                    @endif
                </td>

                <td>

                    @if($order->status == 'verifying')

                    <form action="{{ route('admin.orders.approve',$order->id) }}"
                          method="POST"
                          class="d-inline">
                        @csrf
                        @method('PATCH')

                        <button class="btn btn-success btn-sm">
                            Terima
                        </button>
                    </form>

                    <form action="{{ route('admin.orders.reject',$order->id) }}"
                          method="POST"
                          class="d-inline">
                        @csrf
                        @method('PATCH')

                        <button class="btn btn-danger btn-sm">
                            Tolak
                        </button>
                    </form>

                    @endif

                </td>
            </tr>
        @endforeach
        </tbody>

    </table>
</div>

@endsection