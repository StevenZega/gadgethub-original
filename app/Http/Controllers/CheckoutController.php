<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function buyNow(Product $product)
    {
        $subtotal = $product->price;

        return view('user.checkout', [
            'products' => collect([
                [
                    'product' => $product,
                    'quantity' => 1
                ]
            ]),
            'user' => auth()->user(),
            'subtotal' => $subtotal,
            'checkout_type' => 'buy_now', // Tambahan
            'product_id' => $product->id  // Tambahan
        ]);
    }

    public function cart()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('user.checkout', [
            'user' => auth()->user(),
            'products' => $cartItems,
            'subtotal' => $subtotal,
            'checkout_type' => 'cart' // Tambahan
        ]);
    }

    public function process(Request $request)
    {
        // 1. Validasi Input Alamat
        $request->validate([
            'receiver_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'checkout_type' => 'required|in:buy_now,cart'
        ]);

        $userId = auth()->id();
        $subtotal = 0;
        $orderItemsData = [];

        // 2. Tentukan item yang dibeli & hitung subtotal
        if ($request->checkout_type === 'buy_now') {
            $product = Product::findOrFail($request->product_id);
            $subtotal = $product->price;
            
            $orderItemsData[] = [
                'product_id' => $product->id,
                'price' => $product->price,
                'quantity' => 1,
                'subtotal' => $product->price
            ];
        } else {
            $cartItems = Cart::with('product')->where('user_id', $userId)->get();
            
            if ($cartItems->isEmpty()) {
                return back()->with('error', 'Keranjang Anda kosong.');
            }

            foreach ($cartItems as $item) {
                $itemSubtotal = $item->product->price * $item->quantity;
                $subtotal += $itemSubtotal;
                
                $orderItemsData[] = [
                    'product_id' => $item->product_id,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $itemSubtotal
                ];
            }
        }

        // 3. Buat Record di tabel Orders
        $orders = Order::create([
            'user_id' => $userId,
            'invoice_number' => 'INV-' . strtoupper(Str::random(10)),
            'receiver_name' => $request->receiver_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'notes' => $request->notes,
            'subtotal' => $subtotal,
            'discount' => 0,
            'total' => $subtotal, // Subtotal - discount
            'status' => 'pending' // Menunggu pembayaran
        ]);

        // 4. Buat Record di tabel Order_Items
        foreach ($orderItemsData as $itemData) {
            $orders->items()->create($itemData); 
            // Pastikan Anda punya public function items() { return $this->hasMany(OrderItem::class); } di model Order
        }

        // 5. Bersihkan keranjang jika asalnya dari cart
        if ($request->checkout_type === 'cart') {
            Cart::where('user_id', $userId)->delete();
        }

        // 6. Redirect ke halaman Payment
        return redirect()->route('payment.show', $orders->id);
    }
}