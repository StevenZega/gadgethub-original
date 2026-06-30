<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    public function buyNow(Product $product)
    {
        $subtotal = $product->price;

        // Bersihkan session promo lama agar tidak terbawa saat ganti produk/mode checkout
        session()->forget(['applied_promo_id', 'discount_amount', 'applied_promo_code']);

        return view('user.checkout', [
            'products' => collect([
                [
                    'product' => $product,
                    'quantity' => 1
                ]
            ]),
            'user' => auth()->user(),
            'subtotal' => $subtotal,
            'checkout_type' => 'buy_now',
            'product_id' => $product->id
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

        session()->forget(['applied_promo_id', 'discount_amount', 'applied_promo_code']);

        return view('user.checkout', [
            'user' => auth()->user(),
            'products' => $cartItems,
            'subtotal' => $subtotal,
            'checkout_type' => 'cart'
        ]);
    }

    public function applyPromo(Request $request)
    {
        $code = strtoupper($request->promo_code);
        $userId = auth()->id();
        $subtotal = 0;
        $productsCollection = collect();

        if ($request->checkout_type === 'buy_now') {
            $product = Product::findOrFail($request->product_id);
            $subtotal = $product->price;
            $productsCollection = collect([['product' => $product, 'quantity' => 1]]);
        } else {
            $cartItems = Cart::with('product')->where('user_id', $userId)->get();
            $subtotal = $cartItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });
            $productsCollection = $cartItems;
        }

        $promo = Promo::where('code', $code)
            ->where('is_active', 1)
            ->where('quota', '>', 0)
            ->where('start_date', '<=', Carbon::now())
            ->where('end_date', '>=', Carbon::now())
            ->first();

        if (!$promo) {
            return back()->withInput()->with('error', 'Kode promo tidak valid, kadaluwarsa, atau kuota habis.');
        }

        $discountAmount = ($subtotal * $promo->discount_percent) / 100;

        session()->put('applied_promo_id', $promo->id);
        session()->put('discount_amount', $discountAmount);
        session()->put('applied_promo_code', $promo->code);

        return view('user.checkout', [
            'products' => $productsCollection,
            'user' => auth()->user(),
            'subtotal' => $subtotal,
            'checkout_type' => $request->checkout_type,
            'product_id' => $request->product_id
        ])->with('success', "Promo '{$promo->name}' berhasil digunakan! Diskon {$promo->discount_percent}% diterapkan.");
    }

    public function process(Request $request)
    {
        $request->validate([
            'receiver_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'checkout_type' => 'required|in:buy_now,cart'
        ]);

        $userId = auth()->id();
        $subtotal = 0;
        $orderItemsData = [];

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

        $discount = 0;
        if (session()->has('applied_promo_id')) {
            $promo = Promo::find(session('applied_promo_id'));
            if ($promo && $promo->quota > 0) {
                $discount = session('discount_amount', 0);
                // Potong kuota kupon promo milik admin
                $promo->decrement('quota');
            }
        }

        $total = $subtotal - $discount;

        $order = Order::create([
            'user_id' => $userId,
            'invoice_number' => 'INV-' . strtoupper(Str::random(10)),
            'receiver_name' => $request->receiver_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'notes' => $request->notes,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total, 
            'status' => 'pending'
        ]);

        foreach ($orderItemsData as $itemData) {
            $order->items()->create($itemData); 
        }

        if ($request->checkout_type === 'cart') {
            Cart::where('user_id', $userId)->delete();
        }

        session()->forget(['applied_promo_id', 'discount_amount', 'applied_promo_code']);

        // 8. Redirect ke halaman Payment
        return redirect()->route('payment.show', $order->id);
    }
}