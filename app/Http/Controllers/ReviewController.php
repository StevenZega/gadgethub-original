<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Order; // WAJIB DI-IMPORT
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Menyimpan ulasan produk baru ke database (VERSI JALUR BELAKANG - 100% ANTI DUPLIKAT)
     */
    public function store(Request $request, $product_id)
    {
        // 1. Validasi rating dan komentar saja, kita cuekin input order_id dari form karena sering null/error
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
        ]);

        // 2. JALUR BELAKANG: Cari order_id secara otomatis dari tabel orders yang statusnya 'paid' 
        //    dan memiliki item dengan product_id tersebut milik user ini.
        $order = Order::where('user_id', auth()->id())
            ->where('status', 'paid')
            ->whereHas('items', function($query) use ($product_id) {
                $query->where('product_id', $product_id);
            })
            ->latest() // Ambil transaksi paling baru jika ada beberapa transaksi
            ->first();

        // Jika karena suatu hal tidak ditemukan data order-nya, stop di sini
        if (!$order) {
            return back()->with('error', 'Transaksi untuk produk ini tidak ditemukan atau belum dibayar!');
        }

        $order_id = $order->id;

        // 3. PAGAR KETAT: Cek ke database apakah kombinasi order_id ini dan product_id ini sudah pernah diulas
        $sudahAdaUlasan = Review::where('user_id', auth()->id())
                                ->where('order_id', $order_id)
                                ->where('product_id', $product_id)
                                ->exists();

        // 4. Jika sudah ada di database, LANGSUNG BLOCK! Jangan kasih ampun!
        if ($sudahAdaUlasan) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk produk ini di pesanan ini!');
        }

        // 5. Jika aman dan belum pernah ada, baru simpan ke database
        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $product_id,
            'order_id' => $order_id, // Kita pakai order_id hasil pencarian jalur belakang yang dijamin valids
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Terima kasih! Ulasan Anda berhasil disimpan.');
    }
}