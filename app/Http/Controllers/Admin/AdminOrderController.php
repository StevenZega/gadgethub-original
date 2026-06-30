<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['items.product'])->latest()->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function approve(Order $order)
    {
        if ($order->status === 'paid') {
            return back()->with('error', 'Pesanan ini sudah berstatus dibayar.');
        }

        DB::transaction(function () use ($order) {
            $order->update(['status' => 'paid']);

            foreach ($order->items as $item) {
                $product = $item->product;
                
                if ($product) {
                    $product->decrement('stock', $item->quantity);
                }
            }
        });

        return back()->with('success', 'Pesanan berhasil diterima dan stok produk telah otomatis dikurangi.');
    }

    public function reject(Order $order)
    {
        $order->update(['status' => 'rejected']);
        return back()->with('success', 'Pesanan berhasil ditolak');
    }
}