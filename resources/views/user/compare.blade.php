<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - GadgetHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<div class="grid grid-cols-1 md:grid-cols-11 gap-6 mb-10">

    <!-- Produk A -->
    <div class="md:col-span-5">
        <label class="block text-sm font-bold text-slate-300 mb-2">
            Pilih Produk Pertama (A)
        </label>

        <form action="{{ url('/user/compare') }}" method="GET">
            <input type="hidden" name="product_b" value="{{ request('product_b') }}">

            <select
                name="product_a"
                onchange="this.form.submit()"
                class="w-full rounded-xl bg-slate-800 border border-slate-700 text-white px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">

                <option value="">-- Pilih Produk A --</option>

                @foreach($allProducts as $p)
                    <option value="{{ $p->id }}"
                        {{ request('product_a') == $p->id ? 'selected' : '' }}>
                        [{{ strtoupper($p->brand) }}] {{ $p->name }}
                    </option>
                @endforeach

            </select>
        </form>
    </div>

    <!-- VS -->
    <div class="md:col-span-1 flex items-end justify-center">
        <div class="bg-slate-700 text-white font-bold px-4 py-2 rounded-full">
            VS
        </div>
    </div>

    <!-- Produk B -->
    <div class="md:col-span-5">
        <label class="block text-sm font-bold text-slate-300 mb-2">
            Pilih Produk Kedua (B)
        </label>

        <form action="{{ url('/user/compare') }}" method="GET">
            <input type="hidden" name="product_a" value="{{ request('product_a') }}">

            <select
                name="product_b"
                onchange="this.form.submit()"
                class="w-full rounded-xl bg-slate-800 border border-slate-700 text-white px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">

                <option value="">-- Pilih Produk B --</option>

                @foreach($allProducts as $p)
                    <option value="{{ $p->id }}"
                        {{ request('product_b') == $p->id ? 'selected' : '' }}>
                        [{{ strtoupper($p->brand) }}] {{ $p->name }}
                    </option>
                @endforeach

            </select>
        </form>
    </div>

</div>
@endsection