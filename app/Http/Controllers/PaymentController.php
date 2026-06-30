<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\StoreSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // UBAH BARIS INI: Ambil setting dari admin pemilik produk pertama di dalam order
        $order->load('items.product.admin.storeSetting');
        
        $firstItem = $order->items->first();
        $setting = $firstItem && $firstItem->product && $firstItem->product->admin 
            ? $firstItem->product->admin->storeSetting 
            : null;

        return view('user.payment', compact('order', 'setting'));
    }

    // Fungsi uploadProof di bawahnya biarkan tetap sama, jangan diubah
    public function uploadProof(Request $request, Order $order)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('payment_proof')) {
            if ($order->payment_proof) {
                Storage::disk('public')->delete($order->payment_proof);
            }

            $path = $request->file('payment_proof')->store('payment_proofs', 'public');

            $order->update([
                'payment_proof' => $path,
                'status' => 'verifying'
            ]);

            return back()->with('success', 'Bukti transfer berhasil diunggah! Menunggu konfirmasi admin.');
        }

        return back()->with('error', 'Gagal mengunggah bukti transfer.');
    }
}