<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function approve(Order $order)
    {
        $order->update([
            'status' => 'paid'
        ]);

        return back()->with('success', 'Pesanan berhasil diterima');
    }

    public function reject(Order $order)
    {
        $order->update([
            'status' => 'rejected'
        ]);

        return back()->with('success', 'Pesanan berhasil ditolak');
    }
}