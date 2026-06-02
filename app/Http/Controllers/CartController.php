<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Menampilkan halaman keranjang belanja user
    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('user.cart', compact('cartItems'));
    }

    // Menambahkan produk ke dalam keranjang
    public function addToCart(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        // Validasi ketersediaan stok sebelum masuk keranjang
        if ($product->stock <= 0) {
            return redirect()->back()->with('error', 'Maaf, stok produk ini sedang habis!');
        }

        // Cek apakah produk ini sudah ada di keranjang user tersebut
        $existingCart = Cart::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->first();

        if ($existingCart) {
            // Jika sudah ada, cek apakah penambahan melebihi stok yang ada
            if ($existingCart->quantity + 1 > $product->stock) {
                return redirect()->back()->with('error', 'Jumlah di keranjang melebihi stok yang tersedia!');
            }
            $existingCart->increment('quantity');
        } else {
            // Jika belum ada, buat data baru di tabel carts
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $productId,
                'quantity' => 1
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    // Mengupdate jumlah (quantity) produk dari halaman keranjang
    public function update(Request $request, $id)
    {
        $cart = Cart::where('user_id', auth()->id())->findOrFail($id);
        
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        // Cek apakah kuantitas baru melebihi stok gudang gadget
        if ($request->quantity > $cart->product->stock) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi untuk jumlah tersebut!');
        }

        $cart->update([
            'quantity' => $request->quantity
        ]);

        return redirect()->back()->with('success', 'Jumlah belanjaan berhasil diperbarui!');
    }

    // Menghapus item gadget dari keranjang
    public function destroy($id)
    {
        $cart = Cart::where('user_id', auth()->id())->findOrFail($id);
        $cart->delete();

        return redirect()->back()->with('success', 'Produk dihapus dari keranjang!');
    }
}