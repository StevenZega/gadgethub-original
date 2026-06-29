<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perbandingan Produk</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-[#0f172a] text-white">

<div class="max-w-7xl mx-auto py-10 px-6">

    <div class="flex justify-between items-center mb-8">

        <h1 class="text-3xl font-bold">

            <i class="bi bi-columns-gap text-cyan-400"></i>

            Perbandingan Produk

        </h1>

        <div class="flex gap-3">

<a
href="{{ route('user.dashboard') }}"
class="bg-blue-600 hover:bg-blue-700 px-5 py-2 rounded-xl">

Tambah Produk

</a>

<form action="{{ route('compare.clear') }}" method="POST">

@csrf

@method('DELETE')

<button
class="bg-red-600 hover:bg-red-700 px-5 py-2 rounded-xl">

Kosongkan

</button>

</form>

</div>

        <a href="{{ route('user.dashboard') }}"
            class="bg-blue-600 hover:bg-blue-700 px-5 py-2 rounded-xl">

            Kembali

        </a>

    </div>

    @if($products->count()==0)

        <div class="bg-[#1e293b] rounded-xl p-12 text-center">

            <i class="bi bi-box text-6xl text-slate-500"></i>

            <p class="mt-4 text-xl">

                Belum ada produk untuk dibandingkan.

            </p>

        </div>

    @else

    <div class="overflow-x-auto rounded-2xl border border-slate-700 bg-gradient-to-br from-slate-900 to-[#111827] shadow-2xl">

        <table class="w-full bg-slate-800">

            <tbody>

                {{-- GAMBAR --}}
                <tr class="border-b border-slate-700">

                    <th class="bg-gradient-to-r from-slate-800 to-slate-700 border-l-4 border-cyan-500 p-5 text-left font-bold text-white">
                        <i class="bi bi-phone text-cyan-400 mr-2"></i>
                        Produk
                    </th>

                    @foreach($products as $product)

                        <td class="text-center p-5">

                            <img
                                src="{{ asset('storage/'.$product->image) }}"
                                class="h-40 mx-auto object-contain">

                            <h3 class="font-bold mt-3 text-white-300 text-xl">

                                {{ $product->name }}

                            </h3>

                        </td>

                    @endforeach

                </tr>

                {{-- HARGA --}}
                <tr>

                    <th class="bg-gradient-to-r from-slate-800 to-slate-700 border-l-4 border-yellow-500 p-4 text-left font-bold">
                        <i class="bi bi-cash-coin text-yellow-400 mr-2"></i>
                        Harga
                    </th>

                    @foreach($products as $product)

                        <td class="text-center">

                            @if($product->price == $products->min('price'))

                                <span class="bg-yellow-500 text-black px-3 py-1 rounded-full">

                                Rp {{ number_format($product->price,0,',','.') }}

                                </span>

                                @else

                                Rp {{ number_format($product->price,0,',','.') }}

                                @endif

                        </td>

                    @endforeach

                </tr>

                {{-- BRAND --}}
                <tr>

                    <th class="bg-gradient-to-r from-slate-800 to-slate-700 border-l-4 border-yellow-500 p-4 text-left font-bold">
                        <i class="bi bi-bookmark-star-fill text-blue-400 mr-2"></i>
                        Brand
                    </th>

                    @foreach($products as $product)

                        <td class="text-center">

                            {{ $product->brand }}

                        </td>

                    @endforeach

                </tr>

                {{-- RAM --}}
                <tr>

                    <th class="bg-gradient-to-r from-slate-800 to-slate-700 border-l-4 border-yellow-500 p-4 text-left font-bold">
                        <i class="bi bi-memory text-green-400 mr-2"></i>
                        RAM
                    </th>

                    @foreach($products as $product)

                        <td class="text-center">

                           @if($product->ram == $products->max('ram'))

                        <span
                        class="bg-green-600
                        px-3
                        py-1
                        rounded-full">

                        {{ $product->ram }} GB

                        </span>

                        @else

                        {{ $product->ram }} GB

                        @endif

                        </td>

                    @endforeach

                </tr>


              {{-- STORAGE --}}
                    <tr>
                       <th class="bg-gradient-to-r from-slate-800 to-slate-700 border-l-4 border-yellow-500 p-4 text-left font-bold">
                        <i class="bi bi-device-hdd-fill text-green-400 mr-2"></i>
                        Storage
                    </th>

                        @foreach($products as $product)
                            <td class="text-center">

                                @if($product->storage == $products->max('storage'))
                                    <span class="bg-green-600 px-3 py-1 rounded-full">
                                        {{ $product->storage }} GB
                                    </span>
                                @else
                                    {{ $product->storage }} GB
                                @endif

                            </td>
                        @endforeach

                    </tr>

                    {{-- PROCESSOR --}}
                    <tr class="hover:bg-slate-800/50 transition duration-300">

                        <th class="bg-gradient-to-r from-slate-800 to-slate-700 border-l-4 border-yellow-500 p-4 text-left font-bold">
                            <i class="bi bi-cpu-fill text-orange-400 mr-2"></i>
                            Processor
                        </th>

                        @foreach($products as $product)

                            <td class="text-center">

                                @if($product->processor == $products->max('processor'))

                                    <span class="bg-green-600 px-3 py-1 rounded-full">
                                        {{ $product->processor }}
                                    </span>

                                @else

                                    {{ $product->processor }}

                                @endif

                            </td>

                        @endforeach

                    </tr>

              {{-- BATTERY --}}
                <tr>
                    <th class="bg-gradient-to-r from-slate-800 to-slate-700 border-l-4 border-yellow-500 p-4 text-left font-bold">
                    <i class="bi bi-battery-half text-lime-400 mr-2"></i>
                    Battery
                </th>

                    @foreach($products as $product)
                        <td class="text-center">

                            @if($product->battery_capacity == $products->max('battery_capacity'))
                                <span class="bg-green-600 px-3 py-1 rounded-full">
                                    {{ $product->battery_capacity }} mAh
                                </span>
                            @else
                                {{ $product->battery_capacity }} mAh
                            @endif

                        </td>
                    @endforeach

                </tr>

               {{-- CAMERA --}}
                <tr>
                    <th class="bg-gradient-to-r from-slate-800 to-slate-700 border-l-4 border-yellow-500 p-4 text-left font-bold">
                    <i class="bi bi-camera-fill text-pink-400 mr-2"></i>
                    Kamera
                </th>

                    @foreach($products as $product)
                        <td class="text-center">

                            @if($product->rear_camera == $products->max('rear_camera'))
                                <span class="bg-green-600 px-3 py-1 rounded-full">
                                    {{ $product->rear_camera }} MP
                                </span>
                            @else
                                {{ $product->rear_camera }} MP
                            @endif

                        </td>
                    @endforeach

                </tr>

                {{-- LAYAR --}}
                <tr>

                    <th class="bg-gradient-to-r from-slate-800 to-slate-700 border-l-4 border-yellow-500 p-4 text-left font-bold">
                        <i class="bi bi-display-fill text-cyan-400 mr-2"></i>
                        Screen
                    </th>

                    @foreach($products as $product)

                        <td class="text-center">

                            {{ $product->screen_size ?? '-' }}

                        </td>

                    @endforeach

                </tr>

                {{-- OS --}}
                <tr>

                    <th class="bg-gradient-to-r from-slate-800 to-slate-700 border-l-4 border-yellow-500 p-4 text-left font-bold">
                        <i class="bi bi-windows text-indigo-400 mr-2"></i>
                        OS
                    </th>

                    @foreach($products as $product)

                        <td class="text-center">

                            {{ $product->os ?? '-' }}

                        </td>

                    @endforeach

                </tr>

                {{-- STOCK --}}
                <tr>

                    <th class="bg-gradient-to-r from-slate-800 to-slate-700 border-l-4 border-yellow-500 p-4 text-left font-bold">
                        <i class="bi bi-box-seam-fill text-purple-400 mr-2"></i>
                        Stock
                    </th>

                    @foreach($products as $product)

                        <td class="text-center">

                            {{ $product->stock }}

                        </td>

                    @endforeach

                </tr>

                {{-- ACTION --}}
                <tr>

                    <th class="bg-gradient-to-r from-slate-800 to-slate-700 border-l-4 border-yellow-500 p-4 text-left font-bold">
                        <i class="bi bi-gear-fill text-red-400 mr-2"></i>
                        Action
                    </th>

                    @foreach($products as $product)

                        <td class="text-center py-5">

                            <form
                                action="{{ route('compare.remove',$product->id) }}"
                                method="POST">

                                @csrf
                                @method('DELETE')

                                <button
                                    class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg">

                                    Hapus

                                </button>

                            </form>

                        </td>

                    @endforeach

                </tr>

            </tbody>

        </table>

    </div>

    <div class="mt-8">

    </div>

    @endif

</div>

</body>
</html>