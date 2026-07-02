<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Developer Audit Panel - GadgetHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-[#0f172a] text-slate-100 font-sans antialiased">

    <nav class="bg-[#1e293b]/80 backdrop-blur-xl border-b border-white/10 sticky top-0 z-40 px-6 py-4 flex justify-between items-center">
        <div>
            <h1 class="text-xl font-bold text-white tracking-tight flex items-center gap-2">
                </i> GadgetHub
            </h1>
        </div>
        <div class="flex items-center gap-4">
            <strong class="text-slate-200">{{ auth()->user()->name }}</strong>
            <form action="/logout" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-red-500/10 hover:bg-red-500 hover:text-white border border-red-500/20 text-red-400 px-3 py-1.5 rounded-xl text-sm transition font-medium cursor-pointer">
                    <i class="bi bi-box-arrow-right"></i> Sign Out
                </button>
            </form>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-10">
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-xl flex items-center gap-3">
                <i class="bi bi-check-circle-fill"></i> <span>{{ session('success') }}</span>
            </div>
        @endif
        
        @if(session('error'))
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 text-red-400 rounded-xl flex items-center gap-3">
                <i class="bi bi-exclamation-octagon-fill"></i> <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="bg-[#1e293b] border border-white/10 rounded-2xl overflow-hidden shadow-xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-white/10 bg-white/5 text-slate-300 text-xs uppercase font-mono tracking-wider">
                            <th class="px-6 py-4">Produk</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4">Harga</th>
                            <th class="px-6 py-4">Seller</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5 text-sm">
                        @forelse($products as $product)
                            <tr class="hover:bg-white/[0.02] transition">
                                <td class="px-6 py-4 flex items-center gap-4">
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-12 h-12 object-cover rounded-xl bg-slate-800 border border-white/10" alt="">
                                    <div>
                                        <div class="font-semibold text-white">{{ $product->name }}</div>
                                        <div class="text-xs text-slate-400 max-w-xs truncate mt-0.5">{{ $product->description }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="bg-blue-500/10 text-blue-400 text-xs px-2.5 py-1 rounded-lg font-medium border border-blue-500/10">{{ $product->category }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-emerald-400">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-slate-200">{{ $product->admin->name ?? 'Unknown Admin' }}</div>
                                    <div class="text-xs text-slate-500 font-mono mt-0.5">{{ $product->admin->email ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($product->warnings->count() >= 3)
                                        <span class="bg-red-500/10 text-red-400 text-xs px-2 py-0.5 rounded-md border border-red-500/20 font-medium">
                                            <i class="bi bi-shield-x"></i> Perlu Tindakan
                                        </span>
                                    @elseif($product->warnings->count() > 0)
                                        <span class="bg-amber-500/10 text-amber-400 text-xs px-2 py-0.5 rounded-md border border-amber-500/20 font-medium">
                                            <i class="bi bi-exclamation-triangle-fill"></i> {{ $product->warnings->count() }} Peringatan
                                        </span>
                                    @else
                                        <span class="bg-emerald-500/10 text-emerald-400 text-xs px-2 py-0.5 rounded-md border border-emerald-500/20 font-medium">
                                            <i class="bi bi-shield-check"></i> Sesuai
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        @if($product->warnings->count() >= 3)
                                            <form action="{{ route('developer.product.takedown', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin melakukan TAKEDOWN paksa pada produk ini? Semua data dan gambar produk akan dihapus permanen.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500/10 hover:bg-red-600 hover:text-white border border-red-500/20 text-red-400 px-3 py-1.5 rounded-xl text-xs font-bold transition cursor-pointer">
                                                    <i class="bi bi-shield-slash-fill"></i> Takedown
                                                </button>
                                            </form>
                                        @else
                                            <button type="button" 
                                                    onclick="openWarningModal('{{ $product->id }}', '{{ $product->admin->id ?? '' }}', '{{ $product->name }}', '{{ $product->admin->name ?? 'Admin' }}')"
                                                    class="bg-amber-500/10 hover:bg-amber-500 hover:text-slate-900 border border-amber-500/20 text-amber-400 px-3 py-1.5 rounded-xl text-xs font-semibold transition cursor-pointer">
                                                <i class="bi bi-megaphone-fill"></i> Beri Peringatan
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-slate-500">Belum ada produk apa pun yang diupload oleh admin.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <div id="warning-modal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/80 backdrop-blur-sm flex items-center justify-center opacity-0 pointer-events-none transition-all duration-300">
        <div class="bg-[#1e293b] border border-white/10 w-full max-w-md rounded-2xl overflow-hidden shadow-2xl p-6 transform scale-95 transition-all duration-300">
            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                <i class="bi bi-exclamation-triangle text-amber-400"></i> Peringatan
            </h3>
            
            <form action="{{ route('developer.warning.send') }}" method="POST" class="mt-4">
                @csrf
                <input type="hidden" name="product_id" id="modal-product-id">
                <input type="hidden" name="admin_id" id="modal-admin-id">

                <div class="mb-3 bg-white/5 p-3 rounded-xl border border-white/5 text-xs text-slate-300">
                    <div>Produk: <strong id="modal-product-name" class="text-white"></strong></div>
                    <div class="mt-1">Seller: <strong id="modal-admin-name" class="text-white"></strong></div>
                </div>

                <div class="mb-4">
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-1.5">Catatan</label>
                    <textarea name="message" required rows="4" 
                              class="w-full bg-[#0f172a] border border-white/10 rounded-xl px-4 py-3 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-amber-500 transition-all resize-none"></textarea>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeWarningModal()" class="px-4 py-2 bg-white/5 hover:bg-white/10 rounded-xl text-xs font-semibold text-slate-400 hover:text-white transition cursor-pointer">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 rounded-xl text-xs font-semibold text-slate-900 transition cursor-pointer">Kirim</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('warning-modal');
        const modalContent = modal.querySelector('div');

        function openWarningModal(productId, adminId, productName, adminName) {
            document.getElementById('modal-product-id').value = productId;
            document.getElementById('modal-admin-id').value = adminId;
            document.getElementById('modal-product-name').innerText = productName;
            document.getElementById('modal-admin-name').innerText = adminName;

            modal.classList.remove('opacity-0', 'pointer-events-none');
            modalContent.classList.remove('scale-95');
        }

        function closeWarningModal() {
            modal.classList.add('opacity-0', 'pointer-events-none');
            modalContent.classList.add('scale-95');
        }

        modal.addEventListener('click', function(e) {
            if(e.target === modal) closeWarningModal();
        });
    </script>
</body>
</html>