<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - GadgetHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-[#0f172a] text-white">

<div class="max-w-3xl mx-auto py-10 px-6 mt-5">

    <div class="mb-6">
        <a href="/dashboard" 
           class="inline-flex items-center gap-2 text-slate-400 hover:text-blue-400 transition font-medium">
            <i class="bi bi-arrow-left"></i>
            Kembali ke Dashboard
        </a>
    </div>

    <div class="bg-white/5 border border-white/10 rounded-3xl p-8">
        
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-500/20 border border-green-500/50 text-green-400 rounded-2xl flex items-center gap-3">
                <i class="bi bi-check-circle-fill text-xl"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-blue-500/20 text-blue-400 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                <i class="bi bi-wallet2"></i>
            </div>
            <h1 class="text-3xl font-black mb-1">Selesaikan Pembayaran</h1>
            <p class="text-slate-400">Invoice: <span class="text-white font-mono font-bold">{{ $order->invoice_number }}</span></p>
        </div>

        <div class="bg-[#1e293b] rounded-2xl p-6 mb-8 text-center">
            <h3 class="text-sm text-slate-400 mb-1">Total yang Harus Dibayar</h3>
            <p class="text-4xl font-black text-cyan-400">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-8 bg-[#1e293b] p-2 rounded-2xl">
            <button type="button" id="tab-qr" onclick="switchMethod('qr')" 
                class="py-3 text-center rounded-xl font-bold transition flex items-center justify-center gap-2 bg-blue-600 text-white shadow-lg">
                <i class="bi bi-qr-code-scan"></i> QR Scan / QRIS
            </button>
            <button type="button" id="tab-bank" onclick="switchMethod('bank')" 
                class="py-3 text-center rounded-xl font-bold transition flex items-center justify-center gap-2 text-slate-400 hover:text-white">
                <i class="bi bi-bank"></i> Transfer Bank
            </button>
        </div>

        <div id="content-qr" class="space-y-6 text-center border border-white/10 p-6 rounded-2xl bg-white/5">
            <h3 class="font-bold text-lg flex items-center justify-center gap-2">
                <i class="bi bi-qr-code"></i> Scan QRIS untuk Membayar
            </h3>
            
            <div class="bg-white p-4 rounded-2xl inline-block border border-slate-200">
                @if($setting && $setting->qris_image)

                <img
                    src="{{ asset($setting->qris_image) }}"
                    class="w-60 h-60 object-contain mx-auto rounded-xl"
                    alt="QRIS">

            @else

                <div class="text-center py-10">

                    <i class="bi bi-qr-code text-6xl text-gray-500"></i>

                    <p class="text-slate-400 mt-4">
                        QRIS belum tersedia.
                    </p>

                </div>

            @endif
            </div>

            <p class="text-sm text-slate-400 max-w-md mx-auto">
                Silakan scan QRIS di atas menggunakan aplikasi mobile banking atau e-wallet (Gopay, OVO, Dana, LinkAja) Anda. Jika sudah sukses, unggah buktinya di bawah.
            </p>

            <div class="bg-white/5 border border-white/10 p-6 rounded-2xl text-left mt-4">
                <h3 class="font-bold text-lg mb-4 flex items-center gap-2">
                    <i class="bi bi-cloud-arrow-up"></i> Konfirmasi Pembayaran QRIS
                </h3>

                @if($order->status === 'pending')
                    <form action="{{ route('payment.upload', $order->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm text-slate-400 mb-2">Upload Screenshot Transaksi QRIS</label>
                            <input type="file" name="payment_proof" required
                                class="w-full bg-[#1e293b] border border-white/10 rounded-xl px-4 py-3 text-sm text-slate-400
                                file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold
                                file:bg-blue-600 file:text-white hover:file:bg-blue-700 file:cursor-pointer">
                            @error('payment_proof')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 py-3 rounded-xl font-bold transition flex items-center justify-center gap-2">
                            <i class="bi bi-send"></i> Kirim Bukti Pembayaran QRIS
                        </button>
                    </form>

                @elseif($order->status === 'verifying')
                    <div class="text-center p-4 bg-yellow-500/10 border border-yellow-500/30 text-yellow-400 rounded-xl">
                        <i class="bi bi-hourglass-split text-2xl block mb-2"></i>
                        <p class="font-bold">Bukti QRIS sudah dikirim!</p>
                        <p class="text-sm text-slate-400 mt-1">Admin kami sedang memverifikasi pembayaran Anda.</p>
                    </div>
                    
                    <div class="mt-4 text-center">
                        <p class="text-xs text-slate-400 mb-2">Bukti yang Anda kirim:</p>
                        <img src="{{ asset('storage/' . $order->payment_proof) }}" class="max-h-48 mx-auto rounded-lg border border-white/10 p-1 bg-white/5">
                    </div>
                @endif
            </div>
        </div>

        <div id="content-bank" class="space-y-6 hidden">
            <div class="space-y-4 border border-white/10 p-6 rounded-2xl bg-white/5">

            <h3 class="font-bold text-lg mb-2 flex items-center gap-2">
                <i class="bi bi-bank"></i> Rekening Tujuan Transfer
            </h3>

            <div class="flex justify-between items-center">

                <div>
                    <p class="font-bold">Transfer Bank</p>
                    <p class="text-slate-400 text-sm">
                        {{ $setting->user->name ?? 'GadgetHub' }}
                    </p>
                </div>

                <p class="font-mono text-lg font-bold text-cyan-400">
                    {{ $setting->bank_account ?? '-' }}
                </p>

            </div>

        </div>

            <div class="bg-white/5 border border-white/10 p-6 rounded-2xl">
                <h3 class="font-bold text-lg mb-4 flex items-center gap-2">
                    <i class="bi bi-cloud-arrow-up"></i> Konfirmasi Pembayaran Bank
                </h3>

                @if($order->status === 'pending')
                    <form action="{{ route('payment.upload', $order->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm text-slate-400 mb-2">Upload Foto / Screenshot Bukti Transfer</label>
                            <input type="file" name="payment_proof" required
                                class="w-full bg-[#1e293b] border border-white/10 rounded-xl px-4 py-3 text-sm text-slate-400
                                file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold
                                file:bg-blue-600 file:text-white hover:file:bg-blue-700 file:cursor-pointer">
                            @error('payment_proof')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 py-3 rounded-xl font-bold transition flex items-center justify-center gap-2">
                            <i class="bi bi-send"></i> Kirim Bukti Pembayaran
                        </button>
                    </form>

                @elseif($order->status === 'verifying')
                    <div class="text-center p-4 bg-yellow-500/10 border border-yellow-500/30 text-yellow-400 rounded-xl">
                        <i class="bi bi-hourglass-split text-2xl block mb-2"></i>
                        <p class="font-bold">Bukti Bank sudah dikirim!</p>
                        <p class="text-sm text-slate-400 mt-1">Admin kami sedang memverifikasi pembayaran Transfer Bank Anda.</p>
                    </div>
                    
                    <div class="mt-4 text-center">
                        <p class="text-xs text-slate-400 mb-2">Bukti yang Anda kirim:</p>
                        <img src="{{ asset('storage/' . $order->payment_proof) }}" class="max-h-48 mx-auto rounded-lg border border-white/10 p-1 bg-white/5">
                    </div>
                @endif
            </div>
        </div>

        <div class="text-center mt-8 pt-4 border-t border-white/10">
            <a href="/dashboard" class="text-sm text-slate-400 hover:text-white transition inline-flex items-center gap-2">
                <i class="bi bi-speedometer2"></i> Kembali ke Dashboard Anda
            </a>
        </div>

    </div>
</div>

<script>
    function switchMethod(method) {
        const tabQr = document.getElementById('tab-qr');
        const tabBank = document.getElementById('tab-bank');
        const contentQr = document.getElementById('content-qr');
        const contentBank = document.getElementById('content-bank');

        if (method === 'qr') {
            tabQr.className = "py-3 text-center rounded-xl font-bold transition flex items-center justify-center gap-2 bg-blue-600 text-white shadow-lg";
            tabBank.className = "py-3 text-center rounded-xl font-bold transition flex items-center justify-center gap-2 text-slate-400 hover:text-white";
            contentQr.classList.remove('hidden');
            contentBank.classList.add('hidden');
        } else {
            tabBank.className = "py-3 text-center rounded-xl font-bold transition flex items-center justify-center gap-2 bg-blue-600 text-white shadow-lg";
            tabQr.className = "py-3 text-center rounded-xl font-bold transition flex items-center justify-center gap-2 text-slate-400 hover:text-white";
            contentBank.classList.remove('hidden');
            contentQr.classList.add('hidden');
        }
    }
</script>

</body>
</html>