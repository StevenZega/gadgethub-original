<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use App\Models\Product; 
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::latest()->get();
        return view('admin.promos.index', compact('promos'));
    }

    public function create()
    {
        // Ganti 'user_id' menjadi 'admin_id' sesuai dengan Model Product
        $products = Product::where('admin_id', auth()->id())
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.promos.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'code'             => 'required|string|max:255|unique:promos,code',
            'jenis_cakupan'    => 'required|in:all,category,specific',
            'discount_percent' => 'required|numeric|min:1',
            'quota'            => 'required|numeric|min:0',
            'status'           => 'required|in:aktif,nonaktif',
            'start_date'       => 'required|date',
            'end_date'         => 'required|date|after_or_equal:start_date',
            'category'         => 'required_if:jenis_cakupan,category|nullable|in:Laptop,Handphone',
            'product_id'       => 'required_if:jenis_cakupan,specific|nullable|exists:products,id',
        ]);

        Promo::create([
            'name'             => $request->name,
            'code'             => strtoupper($request->code),
            'scope'            => $request->jenis_cakupan,
            'discount_percent' => $request->discount_percent,
            'quota'            => $request->quota,
            'is_active'        => $request->status === 'aktif' ? 1 : 0,
            'start_date'       => Carbon::parse($request->start_date)->format('Y-m-d H:i:s'), 
            'end_date'         => Carbon::parse($request->end_date)->format('Y-m-d H:i:s'),
            'category'         => $request->jenis_cakupan === 'category' ? $request->category : null,
            'product_id'       => $request->jenis_cakupan === 'specific' ? $request->product_id : null,
        ]);

        return redirect()
            ->route('promos.index')
            ->with('success', 'Promo berhasil ditambahkan');
    }

    public function show(Promo $promo)
    {
        $promo->load('product');
        
        return view('admin.promos.show', compact('promo'));
    }

    public function edit(Promo $promo)
    {
        $products = Product::where('admin_id', auth()->id())
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.promos.edit', compact('promo', 'products'));
    }

    public function update(Request $request, Promo $promo)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'code'             => [
                'required',
                'string',
                'max:255',
                Rule::unique('promos', 'code')->ignore($promo->id),
            ],
            'jenis_cakupan'    => 'required|in:all,category,specific',
            'discount_percent' => 'required|numeric|min:1',
            'quota'            => 'required|numeric|min:0',
            'status'           => 'required|in:aktif,nonaktif',
            'start_date'       => 'required|date',
            'end_date'         => 'required|date|after_or_equal:start_date',
            'category'         => 'required_if:jenis_cakupan,category|nullable|in:Laptop,Handphone',
            'product_id'       => 'required_if:jenis_cakupan,specific|nullable|exists:products,id',
        ]);

        $promo->update([
            'name'             => $request->name,
            'code'             => strtoupper($request->code),
            'scope'            => $request->jenis_cakupan,
            'discount_percent' => $request->discount_percent,
            'quota'            => $request->quota,
            'is_active'        => $request->status === 'aktif' ? 1 : 0,
            'start_date'       => Carbon::parse($request->start_date)->format('Y-m-d H:i:s'),
            'end_date'         => Carbon::parse($request->end_date)->format('Y-m-d H:i:s'),
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