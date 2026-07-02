<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review; // WAJIB
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('items.product') 
            ->latest()
            ->get();

        $reviewedCombinations = Review::where('user_id', auth()->id())
            ->get()
            ->map(function ($review) {
                return $review->order_id . '-' . $review->product_id;
            })
            ->toArray();

        return view('user.orders', compact('orders', 'reviewedCombinations'));
    }
}