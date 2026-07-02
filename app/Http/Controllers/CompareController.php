<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CompareController extends Controller
{
    public function index()
    {
        $compareIds = session()->get('compare', []);

        $products = Product::whereIn('id', $compareIds)->get();

        return view('user.compare', compact('products'));
    }

    public function add(Product $product)
    {
        $compare = session()->get('compare', []);

        if (in_array($product->id, $compare)) {
            return back()->with('info', 'Produk sudah ada di daftar perbandingan.');
        }

        if (count($compare) >= 3) {
            return back()->with('error', 'Maksimal hanya 3 produk yang dapat dibandingkan.');
        }

        $compare[] = $product->id;

        session()->put('compare', $compare);

        return back()->with('success', 'Produk berhasil ditambahkan ke perbandingan.');
    }

    public function remove(Product $product)
    {
        $compare = session()->get('compare', []);

        $compare = array_filter($compare, function ($id) use ($product) {
            return $id != $product->id;
        });

        session()->put('compare', $compare);

        return back()->with('success', 'Produk dihapus dari perbandingan.');
    }

    public function clear()
    {
        session()->forget('compare');

        return back()->with('success', 'Daftar perbandingan dikosongkan.');
    }
}