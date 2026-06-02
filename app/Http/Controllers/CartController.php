<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('user.cart', compact('cartItems'));
    }

    public function addToCart(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        if ($product->stock <= 0) {
            return redirect()->back()->with('error', 'Maaf, stok produk ini sedang habis!');
        }

        $existingCart = Cart::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->first();

        if ($existingCart) {
            if ($existingCart->quantity + 1 > $product->stock) {
                return redirect()->back()->with('error', 'Jumlah di keranjang melebihi stok yang tersedia!');
            }
            $existingCart->increment('quantity');
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $productId,
                'quantity' => 1
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, $id)
    {
        $cart = Cart::where('user_id', auth()->id())->findOrFail($id);
        
        $request->validate([
            'action' => 'required|in:increase,decrease'
        ]);

        if ($request->action == 'increase') {
            if ($cart->quantity + 1 > $cart->product->stock) {
                return redirect()->back()->with('error', 'Stok gadget tidak mencukupi!');
            }
            $cart->increment('quantity');
            $message = 'Jumlah produk berhasil ditambah!';
        } elseif ($request->action == 'decrease') {
            if ($cart->quantity <= 1) {
                $cart->delete();
                return redirect()->back()->with('success', 'Produk dihapus dari keranjang!');
            }
            
            $cart->decrement('quantity');
            $message = 'Jumlah produk berhasil dikurangi!';
        }

        return redirect()->back()->with('success', $message);
    }

    public function destroy($id)
    {
        $cart = Cart::where('user_id', auth()->id())->findOrFail($id);
        $cart->delete();

        return redirect()->back()->with('success', 'Produk dihapus dari keranjang!');
    }
}