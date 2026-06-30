@if($method == 'bank')

    <h1 class="text-3xl font-bold mb-6">
        Transfer Bank
    </h1>

    <div class="bg-white/5 rounded-2xl p-6">

        <div class="mb-4">
            <h4>BCA</h4>
            <p>1234567890</p>
        </div>

        <div class="mb-4">
            <h4>BRI</h4>
            <p>9876543210</p>
        </div>

        <div>
            <h4>Mandiri</h4>
            <p>1122334455</p>
        </div>

    </div>

@endif


@if($method == 'ewallet')

    <h1 class="text-3xl font-bold mb-6">
        E-Wallet
    </h1>

    <div class="bg-white/5 rounded-2xl p-6">

        <div>DANA - 08123456789</div>
        <div>OVO - 08123456789</div>
        <div>GoPay - 08123456789</div>

    </div>

@endif


@if($method == 'cod')

    <h1 class="text-3xl font-bold mb-6">
        Cash On Delivery
    </h1>

    <div class="bg-white/5 rounded-2xl p-6">

        Pembayaran dilakukan saat barang diterima.

    </div>

@endif