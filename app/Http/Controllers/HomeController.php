<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Fungsi __construct() dihapus

    public function index()
    {
        // Tetap pastikan admin tidak tersasar ke sini
        if (auth()->user()->role == 'admin') {
            return redirect('/admin/dashboard');
        }

        $products = Product::where('stock', '>', 0)->latest()->get();
        
        return view('user.index', compact('products'));
    }
}