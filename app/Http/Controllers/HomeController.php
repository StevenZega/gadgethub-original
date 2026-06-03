<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
public function index(Request $request)
{
    if (auth()->user()->role == 'admin') {
        return redirect('/admin/dashboard');
    }

    $products = Product::where('stock', '>', 0);

    // Search
    if ($request->search) {
        $products->where(function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('brand', 'like', '%' . $request->search . '%');
        });
    }

    // Filter category
    if ($request->category) {
        $products->where('category', $request->category);
    }

    // Sorting
    switch ($request->sort) {
        case 'price_asc':
            $products->orderBy('price', 'asc');
            break;

        case 'price_desc':
            $products->orderBy('price', 'desc');
            break;

        case 'name_asc':
            $products->orderBy('name', 'asc');
            break;

        case 'name_desc':
            $products->orderBy('name', 'desc');
            break;

        default:
            $products->latest();
            break;
    }
    

    $products = $products->get();

    return view('user.index', compact('products'));
}

    public function show($id)
    {
        $product = Product::findOrFail($id);
        $seller = User::where('role', 'admin')->first();

        return view('user.show', compact('product', 'seller'));
    }

    public function searchProducts(Request $request)
{
    $search = $request->search;

    $products = Product::where('name', 'like', "%{$search}%")
        ->orWhere('brand', 'like', "%{$search}%")
        ->take(5)
        ->get();

    return response()->json($products);
}
}