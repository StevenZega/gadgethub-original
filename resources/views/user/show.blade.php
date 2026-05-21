<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - GadgetHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900 font-sans">

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('user.dashboard') }}" class="text-2xl font-bold text-blue-600 tracking-wide">
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

    <main class="max-w-5xl mx-auto px-4 py-12">
        <div class="mb-6">
            <a href="{{ route('user.dashboard') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800 flex items-center gap-1">
                &larr; Kembali ke Katalog
            </a>
        </div>

        <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 grid grid-cols-1 md:grid-cols-2 gap-12">
            
            <div class="w-full h-96 bg-gray-50 rounded-2xl flex items-center justify-center overflow-hidden border">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain p-4">
                @else
                    <span class="text-gray-400">No Image Available</span>
                @endif
            </div>

            <div class="flex flex-col justify-between">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 mb-2">{{ $product->name }}</h1>
                    
                    <div class="text-3xl font-black text-blue-600 mb-6">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4 mb-6 space-y-2 border border-gray-100 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Penjual/Admin:</span>
                            <span class="font-semibold text-gray-800">{{ $seller->name ?? 'Admin GadgetHub' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Stok Tersedia:</span>
                            <span class="font-semibold text-gray-800">{{ $product->stock }} unit</span>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h2 class="text-sm font-bold uppercase tracking-wider text-gray-400 mb-2">Deskripsi Produk</h2>
                        <p class="text-gray-600 leading-relaxed whitespace-pre-line">
                            {{ $product->description ?? 'Tidak ada deskripsi lengkap untuk produk ini.' }}
                        </p>
                    </div>
                </div>

                <div class="pt-6 border-t mt-auto">
                    <div class="grid grid-cols-2 gap-4">
                        <button type="button" class="w-full border-2 border-blue-600 text-blue-600 font-bold py-3.5 px-6 rounded-2xl hover:bg-blue-50 transition text-center text-sm">
                            + Keranjang
                        </button>
                        
                        <button type="button" class="w-full bg-blue-600 text-white font-bold py-3.5 px-6 rounded-2xl hover:bg-blue-700 transition shadow-lg shadow-blue-100 text-center text-sm">
                            Checkout Sekarang
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <footer class="bg-gray-900 text-gray-400 py-8 border-t border-gray-800 mt-20">
        <div class="max-w-7xl mx-auto px-4 text-center text-sm">
            &copy; {{ date('Y') }} GadgetHub. All rights reserved.
        </div>
    </footer>

</body>
</html>