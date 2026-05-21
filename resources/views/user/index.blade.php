<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GadgetHub - Toko Gadget Terlengkap</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900 font-sans">

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ url('/user/dashboard') }}" class="text-2xl font-bold text-blue-600 tracking-wide">
                        GADGET<span class="text-gray-800">HUB</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-500">Halo, <strong>{{ auth()->user()->name }}</strong></span>
                    <form action="{{ url('/logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800 transition">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <header class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-20 px-4">
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-4">
                Temukan Gadget Impianmu di Sini
            </h1>
            <p class="text-lg md:text-xl text-blue-100 max-w-2xl mx-auto mb-8">
                Original, bergaransi resmi, dan gratis ongkir ke seluruh Indonesia. Upgrade tokomu, upgrade gayamu!
            </p>
            <a href="#katalog" class="bg-white text-blue-600 font-semibold px-6 py-3 rounded-xl shadow-lg hover:bg-gray-100 transition">
                Jelajahi Produk
            </a>
        </div>
    </header>

    <main id="katalog" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <h2 class="text-3xl font-bold text-gray-800 mb-8 border-b pb-4">Produk Terbaru</h2>

        @if($products->isEmpty())
            <div class="text-center py-12 bg-white rounded-2xl shadow-sm border">
                <p class="text-gray-500 text-lg">Belum ada gadget yang tersedia saat ini.</p>
                <p class="text-gray-400 text-sm mt-1">Silakan isi produk lewat dashboard admin.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach($products as $product)
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md border border-gray-100 transition flex flex-col justify-between">
                        
                        <div>
                            <div class="w-full h-48 bg-gray-100 flex items-center justify-center overflow-hidden">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-gray-400 text-xs">No Image Available</span>
                                @endif
                            </div>

                            <div class="p-5">
                                <h3 class="font-bold text-lg text-gray-800 line-clamp-1 mb-1" title="{{ $product->name }}">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-xs text-gray-400 mb-3">Stok: <span class="font-semibold text-gray-600">{{ $product->stock }}</span></p>
                                <p class="text-gray-600 text-sm line-clamp-2 mb-4">
                                    {{ $product->description ?? 'Tidak ada deskripsi produk.' }}
                                </p>
                            </div>
                        </div>

                        <div class="p-5 pt-0 border-t border-gray-50 mt-auto">
                            <div class="flex items-center justify-between pt-4">
                                <span class="text-xl font-extrabold text-blue-600">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                                <button onclick="alert('Fitur Checkout segera hadir!')" class="bg-blue-50 text-blue-600 font-semibold px-4 py-2 rounded-xl text-sm hover:bg-blue-600 hover:text-white transition">
                                    Beli
                                </button>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </main>

    <footer class="bg-gray-900 text-gray-400 py-8 border-t border-gray-800 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm">
            &copy; {{ date('Y') }} GadgetHub. All rights reserved.
        </div>
    </footer>

</body>
</html>