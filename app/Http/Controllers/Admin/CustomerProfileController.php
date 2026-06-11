<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerProfileController extends Controller
{
    /**
     * Menampilkan tabel semua pembeli (Customer)
     */
    public function index()
    {
        $customers = User::where('role', 'customer')->latest()->get();
        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Menampilkan profil detail pembeli murni tanpa tombol aksi aneh-aneh
     */
    public function show($id)
    {
        $customer = User::where('role', 'customer')->findOrFail($id);
        return view('admin.customers.show', compact('customer'));
    }

    /**
     * Menghapus akun pembeli permanen
     */
    public function destroy($id)
    {
        $customer = User::where('role', 'customer')->findOrFail($id);
        $customer->delete();

        return redirect()
            ->route('customer-profiles.index')
            ->with('success', 'Akun customer berhasil dihapus dari sistem.');
    }
}