<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review; // WAJIB
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Menampilkan riwayat pesanan milik user
     */
    public function index()
    {
        // 1. Ambil data pesanan milik user yang sedang login saat ini beserta item dan produknya
        $orders = Order::where('user_id', auth()->id())
            ->with('items.product') 
            ->latest()
            ->get();

        // 2. Ambil ulasan dalam format gabungan "orderId-productId" (Contoh hasil: ["1-2", "3-2"])
        $reviewedCombinations = Review::where('user_id', auth()->id())
            ->get()
            ->map(function ($review) {
                return $review->order_id . '-' . $review->product_id;
            })
            ->toArray();

        // 3. Kirim data ke view Blade riwayat pesanan
        return view('user.orders', compact('orders', 'reviewedCombinations'));
    }
}