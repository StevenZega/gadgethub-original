<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::latest()->get();

        return view('admin.promos.index', compact('promos'));
    }

    public function create()
    {
        return view('admin.promos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'code'             => 'required|string|max:50|unique:promos,code',
            'jenis_cakupan'    => 'required|in:all,category,specific',
            'discount_percent' => 'required|numeric|min:1|max:100',
            'status'           => 'required|in:aktif,nonaktif',
            'start_date'       => 'required|date',
            'end_date'         => 'required|date|after_or_equal:start_date',
            // Validasi tambahan agar fitur filter produk/kategori temanmu aman
            'category'         => 'nullable|string|max:255',
            'product_id'       => 'nullable|exists:products,id',
        ]);

        Promo::create([
            'name'             => $request->name,
            'code'             => strtoupper($request->code),
            'scope'            => $request->jenis_cakupan, // Dipetakan ke kolom 'scope'
            'discount_percent' => $request->discount_percent,
            'is_active'        => $request->status === 'aktif', // Konversi teks menjadi boolean true/false
            'start_date'       => $request->start_date,
            'end_date'         => $request->end_date,
            'category'         => $request->jenis_cakupan === 'category' ? $request->category : null,
            'product_id'       => $request->jenis_cakupan === 'specific' ? $request->product_id : null,
        ]);

        return redirect()
            ->route('promos.index')
            ->with('success', 'Promo berhasil ditambahkan');
    }

    public function show(Promo $promo)
    {
        return view('admin.promos.show', compact('promo'));
    }

    public function edit(Promo $promo)
    {
        return view('admin.promos.edit', compact('promo'));
    }

    public function update(Request $request, Promo $promo)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'code'             => [
                'required',
                'string',
                'max:50',
                Rule::unique('promos', 'code')->ignore($promo->id),
            ],
            'jenis_cakupan'    => 'required|in:all,category,specific',
            'discount_percent' => 'required|numeric|min:1|max:100',
            'status'           => 'required|in:aktif,nonaktif',
            'start_date'       => 'required|date',
            'end_date'         => 'required|date|after_or_equal:start_date',
            // Validasi tambahan untuk update data
            'category'         => 'nullable|string|max:255',
            'product_id'       => 'nullable|exists:products,id',
        ]);

        $promo->update([
            'name'             => $request->name,
            'code'             => strtoupper($request->code),
            'scope'            => $request->jenis_cakupan, // Dipetakan ke kolom 'scope'
            'discount_percent' => $request->discount_percent,
            'is_active'        => $request->status === 'aktif', // Konversi teks menjadi boolean true/false
            'start_date'       => $request->start_date,
            'end_date'         => $request->end_date,
            'category'         => $request->jenis_cakupan === 'category' ? $request->category : null,
            'product_id'       => $request->jenis_cakupan === 'specific' ? $request->product_id : null,
        ]);

        return redirect()
            ->route('promos.index')
            ->with('success', 'Promo berhasil diperbarui');
    }

    public function destroy(Promo $promo)
    {
        $promo->delete();

        return redirect()
            ->route('promos.index')
            ->with('success', 'Promo berhasil dihapus');
    }
}