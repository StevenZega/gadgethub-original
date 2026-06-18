<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProduk = Product::count();

        $pesananMasuk = Order::count();

        $penjualanHariIni = Order::whereDate('created_at', today())
            ->sum('total');

        return view('admin.dashboard', compact(
            'totalProduk',
            'pesananMasuk',
            'penjualanHariIni'
        ));
    }
}