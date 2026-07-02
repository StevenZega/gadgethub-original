<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\DeveloperWarning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DeveloperDashboardController extends Controller
{
    public function index()
    {
        $products = Product::with('admin', 'warnings')->latest()->get();
        
        return view('developer.dashboard', compact('products'));
    }

    public function sendWarning(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'admin_id'   => 'required|exists:users,id',    
            'message'    => 'required|string|max:1000',
        ]);

        try {
            DeveloperWarning::create([
                'product_id' => $request->product_id,
                'admin_id'   => $request->admin_id,
                'message'    => $request->message,
                'is_read'    => false,
            ]);

            return redirect()->back()->with('success', 'Peringatan berhasil dikirimkan ke admin terkait.');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengirim peringatan: ' . $e->getMessage());
        }
    }

    public function takedown(Product $product)
    {
        if ($product->warnings()->count() < 3) {
            return redirect()->back()->with('error', 'Produk belum mencapai batas maksimal 3 kali peringatan.');
        }

        try {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $product->delete();

            return redirect()->back()->with('success', 'Produk berhasil ditakedown secara permanen karena melanggar aturan 3x.');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal melakukan takedown: ' . $e->getMessage());
        }
    }
}