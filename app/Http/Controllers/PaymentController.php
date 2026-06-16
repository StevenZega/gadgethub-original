<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('user.payment', compact('order'));
    }

    public function uploadProof(Request $request, Order $order)
    {
        // 1. Validasi file harus berupa gambar & maksimal 2MB
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Cek apakah ada file yang diunggah
        if ($request->hasFile('payment_proof')) {
            
            // Hapus foto lama jika user mengunggah ulang
            if ($order->payment_proof) {
                Storage::disk('public')->delete($order->payment_proof);
            }

            // Simpan gambar baru ke folder 'payment_proofs' di disk public
            $path = $request->file('payment_proof')->store('payment_proofs', 'public');

            // 3. Update data order di database
            $order->update([
                'payment_proof' => $path,
                'status' => 'verifying' // Ubah status menjadi menunggu verifikasi admin
            ]);

            return back()->with('success', 'Bukti transfer berhasil diunggah! Menunggu konfirmasi admin.');
        }

        return back()->with('error', 'Gagal mengunggah bukti transfer.');
    }
}