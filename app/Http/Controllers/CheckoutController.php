<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

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
            'subtotal' => $subtotal
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
            'products' => $cartItems,
            'subtotal' => $subtotal
        ]);
    }
}
