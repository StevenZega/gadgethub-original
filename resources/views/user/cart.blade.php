<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - GadgetHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-[#0f172a] text-white font-sans selection:bg-blue-600 selection:text-white">

    <nav class="bg-[#0f172a]/80 backdrop-blur-xl border-b border-white/10 sticky top-0 z-50">
        <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('user.dashboard') }}" class="text-2xl font-black bg-gradient-to-r from-blue-500 to-cyan-400 bg-clip-text text-transparent tracking-wider">
                        GADGET<span class="text-white">HUB</span>
                    </a>
                </div>
                <div class="flex items-center space-x-6">
                    <span class="text-sm text-slate-400">
                        <i class="bi bi-person-circle text-blue-400 mr-1.5"></i> Halo, <strong class="text-white">{{ auth()->user()->name }}</strong>
                    </span>
                    <form action="{{ url('/logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-sm font-semibold text-red-400 hover:text-red-300 transition flex items-center gap-1">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 py-12 relative">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(37,99,235,0.05),transparent_60%)] pointer-events-none"></div>

        <div class="mb-8 relative z-10 flex justify-between items-center">
            <a href="{{ route('user.dashboard') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-400 hover:text-blue-400 transition group">
                <i class="bi bi-arrow-left transition-transform group-hover:-translate-x-1"></i> Kembali Belanja
            </a>
        </div>

        @if($cartItems->isEmpty())
            <div class="text-center py-20 bg-white/5 rounded-3xl border border-white/10 backdrop-blur-sm relative z-10">
                <i class="bi bi-cart-x text-slate-500 text-6xl block mb-4"></i>
                <p class="text-slate-300 text-xl font-medium">Keranjang belanjaanmu masih kosong.</p>
                <p class="text-slate-500 text-sm mt-2 mb-8">Yuk, cari Handphone, Laptop, atau Tablet impianmu sekarang!</p>
                <a href="{{ route('user.dashboard') }}" class="bg-blue-600 text-white font-bold px-6 py-3 rounded-xl text-sm hover:bg-blue-700 transition">
                    Lihat Katalog Gadget
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 relative z-10">
                
                <div class="lg:col-span-2 space-y-4">
                    @php $totalAll = 0; @endphp
                    @foreach($cartItems as $item)
                        @php $totalAll += $item->product->price * $item->quantity; @endphp
                        
                        <div class="bg-white/4 rounded-2xl p-4 border border-white/10 backdrop-blur-md flex items-center gap-4 justify-between">
                            <div class="flex items-center gap-4 flex-1">
                                <div class="w-20 h-20 bg-white/5 rounded-xl border border-white/5 flex items-center justify-center p-2 flex-shrink-0">
                                    @if($item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="" class="w-full h-full object-contain">
                                    @else
                                        <i class="bi bi-image text-slate-500 text-xl"></i>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="font-bold text-sm text-slate-200 line-clamp-1" title="{{ $item->product->name }}">
                                        {{ $item->product->name }}
                                    </h3>
                                    <div class="text-xs text-slate-400 mt-0.5">Rp {{ number_format($item->product->price, 0, ',', '.') }}</div>
                                    <div class="text-sm font-black text-cyan-400 mt-1">
                                        Subtotal: Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row items-end sm:items-center gap-4">
                                <div class="flex items-center bg-slate-900 border border-white/10 rounded-xl overflow-hidden p-0.5">
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="inline m-0">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="action" value="decrease">
                                        <button type="submit" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-red-400 hover:bg-white/5 transition rounded-lg text-xs font-bold">
                                            <i class="bi bi-dash-lg"></i>
                                        </button>
                                    </form>

                                    <span class="w-10 text-center text-xs font-black text-white">
                                        {{ $item->quantity }}
                                    </span>

                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="inline m-0">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="action" value="increase">
                                        <button type="submit" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-blue-400 hover:bg-white/5 transition rounded-lg text-xs font-bold" {{ $item->quantity >= $item->product->stock ? 'disabled' : '' }}>
                                            <i class="bi bi-plus-lg"></i>
                                        </button>
                                    </form>
                                </div>

                                <form action="{{ route('cart.delete', $item->id) }}" method="POST" class="inline m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300 bg-red-500/10 p-2 rounded-xl border border-red-500/20 text-xs transition" title="Hapus dari keranjang">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-white/4 rounded-2xl p-6 border border-white/10 backdrop-blur-md sticky top-24">
                        <h2 class="text-sm font-black uppercase tracking-widest text-slate-400 mb-4 flex items-center gap-1.5">
                            <i class="bi bi-receipt"></i> Ringkasan Belanja
                        </h2>
                        
                        <div class="space-y-3 text-sm pb-4 border-b border-white/5 mb-4">
                            <div class="flex justify-between text-slate-400">
                                <span>Total Item</span>
                                <span class="text-white font-bold">{{ $cartItems->sum('quantity') }} Unit</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center mb-6">
                            <span class="text-sm font-bold text-slate-300">Total Harga:</span>
                            <span class="text-xl font-black text-cyan-400">Rp {{ number_format($totalAll, 0, ',', '.') }}</span>
                        </div>

                        <button type="button" class="w-full bg-gradient-to-r from-blue-600 to-cyan-500 text-white font-bold py-3.5 px-4 rounded-xl text-sm hover:opacity-90 transition shadow-lg shadow-blue-600/10 flex items-center justify-center gap-2">
                            Lanjut ke Pembayaran <i class="bi bi-arrow-right-short text-base"></i>
                        </button>
                    </div>
                </div>

            </div>
        @endif
    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if(session('success'))
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", showConfirmButton: false, timer: 1500, background: '#1e293b', customClass: { popup: 'rounded-4 border border-secondary text-white', title: 'text-white' } });
        @endif
        @if(session('error'))
            Swal.fire({ icon: 'error', title: 'Gagal!', text: "{{ session('error') }}", showConfirmButton: false, timer: 2000, background: '#1e293b', customClass: { popup: 'rounded-4 border border-secondary text-white', title: 'text-white' } });
        @endif
    </script>
</body>
</html>