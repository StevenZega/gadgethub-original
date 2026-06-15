<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - GadgetHub</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-[#0f172a] text-white">

<div class="max-w-6xl mx-auto py-10 px-6">

    <div class="mb-8">
        <a href="{{ url()->previous() }}"
           class="inline-flex items-center gap-2 text-slate-400 hover:text-blue-400">
            <i class="bi bi-arrow-left"></i>
            Kembali
        </a>
    </div>

    <h1 class="text-4xl font-black mb-8">
        Checkout
    </h1>

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        
        <input type="hidden" name="checkout_type" value="{{ $checkout_type ?? 'cart' }}">
        @if(isset($checkout_type) && $checkout_type === 'buy_now')
            <input type="hidden" name="product_id" value="{{ $product_id ?? '' }}">
        @endif

        <div class="grid md:grid-cols-3 gap-8">

            {{-- Produk & Alamat (Kolom Kiri) --}}
            <div class="md:col-span-2">

                <div class="bg-white/5 border border-white/10 rounded-3xl p-6">

                    <h3 class="text-xl font-bold mb-6">
                        Produk yang Dibeli
                    </h3>

                    @foreach($products as $item)

                        @php
                            $product = is_array($item)
                                ? $item['product']
                                : $item->product;

                            $qty = is_array($item)
                                ? $item['quantity']
                                : $item->quantity;
                        @endphp

                        <div class="flex items-center gap-4 py-4 border-b border-white/10">

                            <img
                                src="{{ asset('storage/' . $product->image) }}"
                                class="w-24 h-24 object-contain bg-white rounded-xl p-2">

                            <div class="flex-1">

                                <h5 class="font-bold text-lg">
                                    {{ $product->name }}
                                </h5>

                                <p class="text-slate-400 text-sm">
                                    Qty : {{ $qty }}
                                </p>

                                <p class="text-cyan-400 font-bold mt-2">
                                    Rp {{ number_format($product->price,0,',','.') }}
                                </p>

                            </div>

                        </div>

                    @endforeach

                </div>

                {{-- Alamat Pengiriman --}}
                <div class="bg-white/5 border border-white/10 rounded-3xl p-6 mt-6">

                    <h3 class="text-xl font-bold mb-6">
                        Alamat Pengiriman
                    </h3>

                    <div class="grid md:grid-cols-2 gap-4">

                        <div>
                            <label class="block text-sm text-slate-400 mb-2">
                                Nama Penerima
                            </label>

                            <input
                                type="text"
                                name="receiver_name"
                                required
                                class="w-full bg-[#1e293b] border border-white/10 rounded-xl px-4 py-3 text-white"
                                placeholder="Masukkan nama penerima">
                        </div>

                        <div>
                            <label class="block text-sm text-slate-400 mb-2">
                                Nomor HP
                            </label>

                            <input
                                type="text"
                                name="phone"
                                required
                                class="w-full bg-[#1e293b] border border-white/10 rounded-xl px-4 py-3 text-white"
                                placeholder="08xxxxxxxxxx">
                        </div>

                    </div>

                    <div class="mt-4">

                        <label class="block text-sm text-slate-400 mb-2">
                            Alamat Lengkap
                        </label>

                        <textarea
                            name="address"
                            rows="4"
                            required
                            class="w-full bg-[#1e293b] border border-white/10 rounded-xl px-4 py-3 text-white"
                            placeholder="Masukkan alamat lengkap"></textarea>

                    </div>

                    <div class="mt-4">

                        <label class="block text-sm text-slate-400 mb-2">
                            Catatan Pesanan (Opsional)
                        </label>

                        <textarea
                            name="notes"
                            rows="2"
                            class="w-full bg-[#1e293b] border border-white/10 rounded-xl px-4 py-3 text-white"
                            placeholder="Contoh: Rumah cat putih, pagar hitam"></textarea>

                    </div>

                </div>

            </div>


            {{-- Ringkasan (Kolom Kanan) --}}
            <div>

                <div class="bg-white/5 border border-white/10 rounded-3xl p-6 relative">

                    <h3 class="text-xl font-bold mb-6">
                        Ringkasan Pesanan
                    </h3>

                    <div class="space-y-3">

                        <div class="flex justify-between">
                            <span class="text-slate-400">Subtotal</span>
                            <span>
                                Rp {{ number_format($subtotal,0,',','.') }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-slate-400">Diskon</span>
                            <span class="text-green-400">
                                Rp 0
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-slate-400">Ongkir</span>
                            <span>
                                Gratis
                            </span>
                        </div>

                    </div>

                    <hr class="border-white/10 my-5">

                    <div class="flex justify-between text-xl font-black">

                        <span>Total</span>

                        <span class="text-cyan-400">
                            Rp {{ number_format($subtotal,0,',','.') }}
                        </span>

                    </div>

                    <button
                        type="submit"
                        class="w-full mt-6 bg-blue-600 hover:bg-blue-700 py-4 rounded-2xl font-bold transition">

                        <i class="bi bi-credit-card"></i>
                        Buat Pesanan

                    </button>

                </div>

            </div>

        </div>
    </form>

</div>

</body>
</html>