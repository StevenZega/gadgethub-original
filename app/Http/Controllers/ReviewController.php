<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Order; // WAJIB DI-IMPORT
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, $product_id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
        ]);

        $order = Order::where('user_id', auth()->id())
            ->where('status', 'paid')
            ->whereHas('items', function($query) use ($product_id) {
                $query->where('product_id', $product_id);
            })
            ->latest() 
            ->first();

        if (!$order) {
            return back()->with('error', 'Transaksi untuk produk ini tidak ditemukan atau belum dibayar!');
        }

        $order_id = $order->id;

        $sudahAdaUlasan = Review::where('user_id', auth()->id())
                                ->where('order_id', $order_id)
                                ->where('product_id', $product_id)
                                ->exists();

        if ($sudahAdaUlasan) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk produk ini di pesanan ini!');
        }

        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $product_id,
            'order_id' => $order_id, 
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Terima kasih! Ulasan Anda berhasil disimpan.');
    }
}