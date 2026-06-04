<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GadgetHub - Toko Gadget Terlengkap</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-[#0f172a] text-white font-sans selection:bg-blue-600 selection:text-white">

    <nav class="bg-[#0f172a]/80 backdrop-blur-xl border-b border-white/10 sticky top-0 z-50">
        <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ url('/user/dashboard') }}" class="text-2xl font-black bg-gradient-to-r from-blue-500 to-cyan-400 bg-clip-text text-transparent tracking-wider">
                        GADGET<span class="text-white">HUB</span>
                    </a>
                </div>
                <form method="GET" action="{{ route('user.dashboard') }}" class="flex items-center gap-2">
                    <div class="relative">
                    <!-- Search -->
                    <input
                        type="text"
                        id="search-input"
                        name="search"
                        placeholder="🔍 Cari produk..."
                        value="{{ request('search') }}"
                        class="bg-white/5 border border-white/10 rounded-xl px-4 py-2 text-white w-56 focus:outline-none focus:border-blue-500">
                        <div id="search-results"
                            class="hidden absolute top-full left-0 mt-2 w-full bg-[#1e293b] border border-white/10 rounded-xl overflow-hidden shadow-xl z-50">
                        </div>
                    </div>

                    <!-- Category -->
                    <select
                        name="category"
                        class="bg-[#1e293b] border border-white/10 rounded-xl px-4 py-2 text-white focus:outline-none focus:border-blue-500">

                        <option value="">Semua</option>

                        <option value="Handphone"
                            {{ request('category') == 'Handphone' ? 'selected' : '' }}>
                            Handphone
                        </option>

                        <option value="Laptop"
                            {{ request('category') == 'Laptop' ? 'selected' : '' }}>
                            Laptop
                        </option>

                    </select>

                    <!-- Sort -->
                    <select
                        name="sort"
                        class="bg-[#1e293b] border border-white/10 rounded-xl px-4 py-2 text-white focus:outline-none focus:border-blue-500">

                        <option value="">↕ Urutkan</option>

                        <option value="price_asc"
                            {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                            Harga Terendah
                        </option>

                        <option value="price_desc"
                            {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                            Harga Tertinggi
                        </option>

                        <option value="name_asc"
                            {{ request('sort') == 'name_asc' ? 'selected' : '' }}>
                            Nama A-Z
                        </option>

                        <option value="name_desc"
                            {{ request('sort') == 'name_desc' ? 'selected' : '' }}>
                            Nama Z-A
                        </option>

                    </select>

                    <!-- Filter Button -->
                    <button
                        type="submit"
                        class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-xl font-semibold transition">
                        <i class="bi bi-funnel-fill"></i>
                    </button>

                    <!-- Reset -->
                    <a href="{{ route('user.dashboard') }}"
                    class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-xl transition">
                        <i class="bi bi-x-lg"></i>
                    </a>

                </form>            
                <div class="flex items-center space-x-6">
                    <a href="{{ route('cart.index') }}" class="text-slate-400 hover:text-blue-400 text-xl p-1.5 transition flex items-center relative group" title="Buka Keranjang">
                        <i class="bi bi-cart-fill"></i>
                        <span class="absolute -top-1 -right-1 w-2 h-2 bg-blue-500 rounded-full opacity-0 group-hover:opacity-100 transition"></span>
                    </a>

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

    <header class="relative overflow-hidden bg-[#0f172a] border-b border-white/5 py-24 px-4">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(37,99,235,0.12),transparent_45%)]"></div>
        <div class="max-w-4xl mx-auto text-center relative z-10">
            <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20 mb-4">
                <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 animate-pulse"></span> Generasi Baru Belanja Gadget
            </span>
            <h1 class="text-4xl md:text-6xl font-black tracking-tight mb-6 bg-gradient-to-b from-white to-slate-300 bg-clip-text text-transparent">
                Temukan Gadget Masa Depanmu
            </h1>
            <p class="text-base md:text-lg text-slate-400 max-w-2xl mx-auto mb-10 leading-relaxed">
                Produk 100% original, bergaransi resmi, dan gratis ongkir ke seluruh Indonesia. Upgrade produktivitas dan gayamu sekarang!
            </p>
            <a href="#katalog" class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-cyan-500 text-white font-bold px-8 py-4 rounded-2xl shadow-lg shadow-blue-500/20 hover:opacity-90 transition transform hover:-translate-y-0.5">
                Jelajahi Produk <i class="bi bi-arrow-down-short fs-5"></i>
            </a>
        </div>
    </header>

    <main id="katalog" class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex items-center gap-3 mb-10 border-b border-white/10 pb-5">
            <div class="p-2 rounded-xl bg-blue-600/10 border border-blue-500/20 text-blue-400">
                <i class="bi bi-cpu-fill text-xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-extrabold tracking-tight text-white m-0">Katalog Gadget Terbaru</h2>
                <p class="text-xs text-slate-400 mt-0.5">Menampilkan deretan device spesifikasi terbaik</p>
            </div>
        </div>

        @if($products->count() > 0)

            @foreach($products as $product)
                {{-- card produk --}}
            @endforeach

        @else

            <div class="text-center py-5">
                <i class="bi bi-search fs-1"></i>
                <h4 class="mt-3">Produk tidak ditemukan</h4>
                <p>Coba gunakan kata kunci lain.</p>
            </div>

        @endif

        @if($products->isEmpty())
            <div class="text-center py-20 bg-white/5 rounded-3xl border border-white/10 backdrop-blur-sm">
                <i class="bi bi-patch-exclamation text-slate-500 text-5xl block mb-4"></i>
                <p class="text-slate-300 text-xl font-medium">Belum ada gadget yang tersedia saat ini.</p>
                <p class="text-slate-500 text-sm mt-2">Silakan tambahkan produk baru melalui dashboard manajemen admin.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-6">
                @foreach($products as $product)
                    <div class="bg-white/4 rounded-2xl overflow-hidden border border-white/10 backdrop-blur-md hover:border-blue-500/40 hover:shadow-2xl hover:shadow-blue-500/5 transition duration-300 flex flex-col justify-between group relative">
                        
                        <a href="{{ route('user.products.show', $product->id) }}" class="block flex-1">
                            <div class="w-full h-44 bg-white/5 flex items-center justify-center overflow-hidden border-b border-white/5 relative">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain p-4 group-hover:scale-105 transition duration-300">
                                @else
                                    <div class="text-slate-500 flex flex-col items-center gap-2">
                                        <i class="bi bi-image text-2xl"></i>
                                        <span class="text-[10px] tracking-wider uppercase">No Image</span>
                                    </div>
                                @endif
                            </div>

                            <div class="p-4 pb-0">
                                <h3 class="font-bold text-sm text-slate-200 line-clamp-2 mb-2 group-hover:text-blue-400 transition" title="{{ $product->name }}">
                                    {{ $product->name }}
                                </h3>
                                <div class="text-base font-black text-cyan-400">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </div>
                            </div>
                        </a>

                        <div class="p-4 pt-4 mt-3">
                            <div class="grid grid-cols-1 gap-2">
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center justify-center gap-1.5 border border-white/10 text-slate-300 font-semibold py-2 px-3 rounded-xl text-xs hover:bg-white/10 hover:text-white transition">
                                        <i class="bi bi-cart-plus"></i> + Keranjang
                                    </button>
                                </form>
                                <button type="button" class="w-full bg-blue-600 text-white font-bold py-2 px-3 rounded-xl text-xs hover:bg-blue-700 transition shadow-md shadow-blue-600/10">
                                    Checkout
                                </button>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </main>

    <footer class="bg-[#0b111e] text-slate-500 py-10 border-t border-white/5 mt-32">
        <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 text-center text-xs tracking-wider">
            &copy; {{ date('Y') }} GADGETHUB INDONESIA. All rights reserved.
        </div>
    </footer>

    <script>
const searchInput = document.getElementById('search-input');
const resultsBox = document.getElementById('search-results');

searchInput.addEventListener('keyup', async function() {

    let keyword = this.value;

    if(keyword.length < 1){
        resultsBox.classList.add('hidden');
        return;
    }

    let response = await fetch(`/search-products?search=${keyword}`);
    let products = await response.json();

    let html = '';

    products.forEach(product => {
        html += `
            <a href="/user/products/${product.id}"
               class="block px-4 py-3 hover:bg-white/5 border-b border-white/5">

                <div class="font-semibold text-white">
                    ${product.name}
                </div>

                <div class="text-xs text-slate-400">
                    ${product.brand ?? ''}
                </div>

            </a>
        `;
    });

    if(products.length === 0){
        html = `
            <div class="px-4 py-3 text-slate-400">
                Produk tidak ditemukan
            </div>
        `;
    }

    resultsBox.innerHTML = html;
    resultsBox.classList.remove('hidden');
    
});
</script>

</body>
</html>