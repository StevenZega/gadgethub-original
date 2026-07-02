<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\DeveloperWarning;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProduk = Product::where('admin_id', auth()->id())->count();

        $pesananMasuk = Order::where('status', 'verifying')->count();

        $penjualanHariIni = Order::where('status', 'paid')
            ->whereDate('created_at', today())
            ->sum('total');

        return view('admin.dashboard', compact(
            'totalProduk',
            'pesananMasuk',
            'penjualanHariIni'
        ));
    }

    public function notifications()
    {
        $warnings = DeveloperWarning::with('product')
            ->where('admin_id', auth()->id())
            ->latest()
            ->get();

        return view('admin.notifications.index', compact('warnings'));
    }

    public function markAsRead($id)
    {
        $warning = DeveloperWarning::where('admin_id', auth()->id())->findOrFail($id);
        $warning->update(['is_read' => true]);

        return redirect()->back()->with('success', 'Pesan ditandai sebagai dibaca.');
    }
}