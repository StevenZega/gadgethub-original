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
            <h1 class="text-3xl font-bold">Riwayat Pesanan</h1>
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
                            <h3 class="font-bold text-lg">{{ $order->invoice_number }}</h3>
                            <p class="text-slate-400 text-sm mt-1">{{ $order->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div>
                            @if($order->status == 'pending')
                            <span class="bg-yellow-500/20 text-yellow-400 px-4 py-2 rounded-xl text-sm">Ditunda</span>
                            @elseif($order->status == 'verifying')
                            <span class="bg-orange-500/20 text-orange-400 px-4 py-2 rounded-xl text-sm">Verifikasi</span>
                            @elseif($order->status == 'paid')
                            <span class="bg-green-500/20 text-green-400 px-4 py-2 rounded-xl text-sm font-medium">Dibayar</span>
                            @elseif($order->status == 'diproses')
                            <span class="bg-blue-500/20 text-blue-400 px-4 py-2 rounded-xl text-sm">Diproses</span>
                            @elseif($order->status == 'dikirim')
                            <span class="bg-cyan-500/20 text-cyan-400 px-4 py-2 rounded-xl text-sm">Dikirim</span>
                            @elseif($order->status == 'selesai')
                            <span class="bg-green-500/20 text-green-400 px-4 py-2 rounded-xl text-sm">Selesai</span>
                            @elseif($order->status == 'rejected')
                            <span class="bg-red-500/20 text-red-400 px-4 py-2 rounded-xl text-sm">Ditolak</span>
                            @else
                            <span class="bg-slate-500/20 text-slate-300 px-4 py-2 rounded-xl text-sm">{{ ucfirst($order->status) }}</span>
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
                                        <p class="text-xs text-slate-400 mt-1">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                    <span class="text-sm text-slate-400 bg-white/10 px-2.5 py-1 rounded-md border border-white/5">
                                        x{{ $item->quantity }}
                                    </span>

                                    @if($order->status == 'paid' && $item->product)
                                        @php
                                            $gabunganId = $order->id . '-' . $item->product_id;
                                        @endphp

                                        @if(isset($reviewedCombinations) && in_array($gabunganId, $reviewedCombinations))
                                            <span class="text-xs font-bold text-green-400 bg-green-500/10 border border-green-500/20 px-2.5 py-1.5 rounded-xl flex items-center gap-1">
                                                <i class="bi bi-check-circle-fill text-[10px]"></i> Sudah Diulas
                                            </span>
                                        @else
                                            <button type="button" 
                                                onclick="openReviewModal('{{ $item->product_id }}', '{{ addslashes($item->product->name) }}', '{{ $order->id }}')" 
                                                class="bg-amber-500 hover:bg-amber-400 text-slate-900 font-bold px-3 py-1.5 rounded-xl text-xs transition flex items-center gap-1 shadow-lg shadow-amber-500/10">
                                                <i class="bi bi-star-fill text-[10px]"></i> Ulas
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-white/10 mt-6 pt-4 flex justify-between">
                        <span class="text-slate-400">Total Pembayaran</span>
                        <span class="text-cyan-400 font-bold text-lg">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white/5 border border-white/10 rounded-3xl py-20 text-center">
            <i class="bi bi-box-seam text-6xl text-slate-500"></i>
            <h3 class="text-xl font-bold mt-5">Belum Ada Pesanan</h3>
            <p class="text-slate-400 mt-2">Anda belum pernah melakukan transaksi.</p>
        </div>
    @endif

</div>

<div id="reviewModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm" onclick="closeReviewModal()"></div>
    
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="relative bg-[#1e293b] border border-white/10 rounded-3xl max-w-md w-full p-6 shadow-2xl overflow-hidden">
            
            <div class="flex justify-between items-center pb-3 mb-4 border-b border-white/10">
                <h3 class="text-base font-bold text-white flex items-center gap-2">
                    <i class="bi bi-chat-left-heart-fill text-amber-400"></i> Beri Ulasan Produk
                </h3>
                <button type="button" onclick="closeReviewModal()" class="text-slate-400 hover:text-white transition">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <p class="text-xs text-slate-400 mb-4 font-medium">Gadget: <span id="modalProductName" class="text-blue-400 font-bold"></span></p>

            <form id="reviewForm" action="" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="order_id" id="modalOrderId">

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Pilih Nilai Rating Bintang</label>
                    <select name="rating" required class="w-full bg-[#0f172a] border border-white/10 rounded-xl px-3 py-2.5 text-sm text-amber-400 font-bold focus:outline-none focus:border-blue-500 transition">
                        <option value="5">⭐⭐⭐⭐⭐ (5 - Sangat Puas)</option>
                        <option value="4">⭐⭐⭐⭐ (4 - Puas)</option>
                        <option value="3">⭐⭐⭐ (3 - Cukup)</option>
                        <option value="2">⭐⭐ (2 - Kurang Puas)</option>
                        <option value="1">⭐ (1 - Kecewa)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Tulis Komentar Ulasan</label>
                    <textarea name="comment" rows="3" required placeholder="Ceritakan kepuasan Anda terhadap performa gadget ini..." class="w-full bg-white/5 border border-white/10 focus:border-blue-500 focus:outline-none rounded-xl px-4 py-2.5 text-sm text-slate-200 transition leading-relaxed"></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="button" onclick="closeReviewModal()" class="bg-white/5 hover:bg-white/10 text-slate-300 px-4 py-2 rounded-xl text-xs font-semibold transition">
                        Batal
                    </button>
                    <button type="submit" class="bg-amber-500 hover:bg-amber-400 text-slate-900 px-4 py-2 rounded-xl text-xs font-bold shadow-lg transition">
                        Kirim Ulasan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openReviewModal(productId, productName, orderId) {
        const modal = document.getElementById('reviewModal');
        const form = document.getElementById('reviewForm');
        const nameSpan = document.getElementById('modalProductName');
        const orderInput = document.getElementById('modalOrderId');

        form.action = `/user/reviews/store/${productId}`;
        nameSpan.innerText = productName;
        orderInput.value = orderId;

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeReviewModal() {
        const modal = document.getElementById('reviewModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
</script>
</body>
</html>