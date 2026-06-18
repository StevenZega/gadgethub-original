<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('user.orders', compact('orders'));
    }
}