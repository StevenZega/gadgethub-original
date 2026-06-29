<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class AdminOrderController extends Controller
{
    public function index()
    {
        // FILTER PESANAN: Hanya tampil jika item pesanan berisi produk milik admin aktif
        $orders = Order::whereHas('items.product', function($query) {
            $query->where('admin_id', auth()->id());
        })->with(['items.product'])->latest()->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function approve(Order $order)
    {
        $order->update(['status' => 'paid']);
        return back()->with('success', 'Pesanan berhasil diterima');
    }

    public function reject(Order $order)
    {
        $order->update(['status' => 'rejected']);
        return back()->with('success', 'Pesanan berhasil ditolak');
    }
}