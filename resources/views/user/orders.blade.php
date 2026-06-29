<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-[#0f172a] text-white min-h-screen">

<div class="max-w-7xl mx-auto px-6 py-10">

    <div class="flex justify-between items-center mb-10">

        <div>
            <h1 class="text-3xl font-bold">
                Riwayat Pesanan
            </h1>
        </div>

        <a href="{{ route('user.dashboard') }}"
            class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-xl font-medium transition">
            Kembali
        </a>

    </div>

    @if($orders->count())

        <div class="space-y-5">

            @foreach($orders as $order)

                <div class="bg-white/5 border border-white/10 rounded-2xl p-6">

                    <div class="flex justify-between items-start">

                        <div>

                            <h3 class="font-bold text-lg">
                                {{ $order->invoice_number }}
                            </h3>

                            <p class="text-slate-400 text-sm mt-1">
                                {{ $order->created_at->format('d M Y H:i') }}
                            </p>

                        </div>

                        <div>

                            @if($order->status == 'pending')
                            <span class="bg-yellow-500/20 text-yellow-400 px-4 py-2 rounded-xl text-sm">
                                Ditunda
                            </span>

                        @elseif($order->status == 'verifying')
                            <span class="bg-orange-500/20 text-orange-400 px-4 py-2 rounded-xl text-sm">
                                Verifikasi
                            </span>

                        @elseif($order->status == 'paid')
                            <span class="bg-green-500/20 text-green-400 px-4 py-2 rounded-xl text-sm font-medium">
                                Dibayar
                            </span>

                        @elseif($order->status == 'diproses')
                            <span class="bg-blue-500/20 text-blue-400 px-4 py-2 rounded-xl text-sm">
                                Diproses
                            </span>

                        @elseif($order->status == 'dikirim')
                            <span class="bg-cyan-500/20 text-cyan-400 px-4 py-2 rounded-xl text-sm">
                                Dikirim
                            </span>

                        @elseif($order->status == 'selesai')
                            <span class="bg-green-500/20 text-green-400 px-4 py-2 rounded-xl text-sm">
                                Selesai
                            </span>

                        @elseif($order->status == 'rejected')
                            <span class="bg-red-500/20 text-red-400 px-4 py-2 rounded-xl text-sm">
                                Ditolak
                            </span>

                        @else
                            <span class="bg-slate-500/20 text-slate-300 px-4 py-2 rounded-xl text-sm">
                                {{ ucfirst($order->status) }}
                            </span>
                        @endif

                        </div>

                    </div>

                    <div class="mt-6 space-y-4">
                        
                        @foreach($order->items as $item)
                            <div class="flex items-center justify-between bg-white/5 p-4 rounded-xl border border-white/5">
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-16 bg-[#1e293b] rounded-lg flex items-center justify-center overflow-hidden p-2 border border-white/10">
                                        @if($item->product && $item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-contain">
                                        @else
                                            <i class="bi bi-image text-slate-500 text-xl"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-sm text-slate-200 line-clamp-1">
                                            {{ $item->product->name ?? 'Produk Telah Dihapus' }}
                                        </h4>
                                        <p class="text-xs text-slate-400 mt-1">
                                            Rp {{ number_format($item->price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-sm text-slate-400 bg-white/10 px-2.5 py-1 rounded-md border border-white/5">
                                        x{{ $item->quantity }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-white/10 mt-6 pt-4 flex justify-between">

                        <span class="text-slate-400">
                            Total Pembayaran
                        </span>

                        <span class="text-cyan-400 font-bold text-lg">
                            Rp {{ number_format($order->total, 0, ',', '.') }}
                        </span>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        <div class="bg-white/5 border border-white/10 rounded-3xl py-20 text-center">

            <i class="bi bi-box-seam text-6xl text-slate-500"></i>

            <h3 class="text-xl font-bold mt-5">
                Belum Ada Pesanan
            </h3>

            <p class="text-slate-400 mt-2">
                Anda belum pernah melakukan transaksi.
            </p>

        </div>

    @endif

</div>

</body>
</html>