<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        // Memakai relasi 'items.product' sesuai isi Model-mu
        $orders = Order::where('user_id', auth()->id())
            ->with('items.product') 
            ->latest()
            ->get();

        return view('user.orders', compact('orders'));
    }
}