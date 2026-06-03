<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use App\Models\Product;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    // 1. Tampilkan semua list promo yang sudah dibuat admin
    public function index()
    {
        $promos = Promo::with('product')->latest()->get();
        return view('admin.promos.index', compact('promos'));
    }

    // 2. Tampilkan form pembuatan promo baru
    public function create()
    {
        $products = Product::orderBy('name')->get();
        return view('admin.promos.create', compact('products'));
    }

    // 3. Proses simpan promo ke database
    public function store(Request $request)
    {
        $data = $request->validate([
            'code'             => 'required|string|unique:promos,code|max:50',
            'name'             => 'required|string|max:255',
            'discount_percent' => 'required|integer|min:1|max:100',
            'scope'            => 'required|in:all,category,specific',
            'category'         => 'nullable|required_if:scope,category|string|max:100',
            'product_id'       => 'nullable|required_if:scope,specific|exists:products,id',
            'start_date'       => 'required|date',
            'end_date'         => 'required|date|after_or_equal:start_date',
        ]);

        // Otomatis ubah kode kupon jadi huruf besar (Caps Lock)
        $data['code'] = strtoupper($data['code']);

        Promo::create($data);

        return redirect()->route('promos.index')->with('success', 'Promo baru berhasil dirilis!');
    }

    // 4. Hapus promo
    public function destroy(Promo $promo)
    {
        $promo->delete();
        return redirect()->route('promos.index')->with('success', 'Promo berhasil dihapus!');
    }

    // 5. Tampilkan form edit promo
    public function edit(Promo $promo)
    {
        $products = \App\Models\Product::orderBy('name')->get();
        return view('admin.promos.edit', compact('promo', 'products'));
    }

    // 6. Proses simpan perubahan data promo
    public function update(Request $request, Promo $promo)
    {
        $data = $request->validate([
            'code'             => 'required|string|max:50|unique:promos,code,' . $promo->id,
            'name'             => 'required|string|max:255',
            'discount_percent' => 'required|integer|min:1|max:100',
            'scope'            => 'required|in:all,category,specific',
            'category'         => 'nullable|required_if:scope,category|string|max:100',
            'product_id'       => 'nullable|required_if:scope,specific|exists:products,id',
            'start_date'       => 'required|date',
            'end_date'         => 'required|date|after_or_equal:start_date',
        ]);

        $data['code'] = strtoupper($data['code']);

        $promo->update($data);

        return redirect()->route('promos.index')->with('success', 'Promo berhasil diperbarui!');
    }

    // 7. Tampilkan detail promo
    public function show(Promo $promo)
    {
    // Mengarahkan ke file view show yang baru saja kita buat di atas
        return view('admin.promos.show', compact('promo'));
    }
}