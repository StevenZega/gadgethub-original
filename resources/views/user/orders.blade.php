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

            <p class="text-slate-400 mt-2">
                Semua transaksi yang pernah Anda lakukan.
            </p>
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

                    <div class="grid md:grid-cols-2 gap-4 mt-6">

                        <div>
                            <p class="text-slate-400 text-sm">
                                Nama Penerima
                            </p>

                            <p class="font-semibold">
                                {{ $order->receiver_name }}
                            </p>
                        </div>

                        <div>
                            <p class="text-slate-400 text-sm">
                                Nomor HP
                            </p>

                            <p class="font-semibold">
                                {{ $order->phone }}
                            </p>
                        </div>

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