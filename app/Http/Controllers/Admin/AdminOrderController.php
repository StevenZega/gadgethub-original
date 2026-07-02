<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderApprovedMail;
use Illuminate\Support\Facades\DB;

class AdminOrderController extends Controller
{
    public function index()
    {
        $adminId = auth()->id();

        $orders = Order::whereHas('items.product', function ($query) use ($adminId) {
            $query->where('admin_id', $adminId);
        })
        ->with(['items.product' => function ($query) use ($adminId) {
          $query->where('admin_id', $adminId);
        }, 'user'])
        ->latest()
        ->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function approve(Order $order)
    {
        $adminId = auth()->id();

        $hasProduct = $order->items()->whereHas('product', function($query) use ($adminId) {
            $query->where('admin_id', $adminId);
        })->exists();

        if (!$hasProduct) {
            abort(403, 'Anda tidak memiliki otoritas pada pesanan ini.');
        }

        if ($order->status === 'paid') {
            return back()->with('error', 'Pesanan ini sudah berstatus dibayar.');
        }

        DB::transaction(function () use ($order, $adminId) {
            $order->update(['status' => 'paid']);

            foreach ($order->items as $item) {
                $product = $item->product;
                
                if ($product && $product->admin_id == $adminId) {
                    $product->decrement('stock', $item->quantity);
                }
            }
        });

        if ($order->user && $order->user->email) {
            Mail::to($order->user->email)->send(new OrderApprovedMail($order));
        }

        return back()->with('success', 'Pesanan berhasil diterima, stok produk Anda otomatis dikurangi, dan email notifikasi telah dikirim ke customer.');
    }

    public function reject(Order $order)
    {
        $adminId = auth()->id();
        
        $hasProduct = $order->items()->whereHas('product', function($query) use ($adminId) {
            $query->where('admin_id', $adminId);
        })->exists();

        if (!$hasProduct) {
            abort(403, 'Anda tidak memiliki otoritas pada pesanan ini.');
        }

        $order->update(['status' => 'rejected']);
        return back()->with('success', 'Pesanan berhasil ditolak');
    }
}