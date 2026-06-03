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
            'nama_promo' => 'required|string|max:255',

            'kode_promo' => 'required|string|max:50|unique:promos,kode_promo',

            // TAMBAHAN JENIS CAKUPAN
            'jenis_cakupan' => 'required|in:all,category,specific',

            'diskon' => 'required|numeric|min:1|max:100',

            'status' => 'required|in:aktif,nonaktif',

            'tanggal_mulai' => 'required|date',

            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        Promo::create([
            'nama_promo'      => $request->nama_promo,

            'kode_promo'      => strtoupper($request->kode_promo),

            // TAMBAHAN JENIS CAKUPAN
            'jenis_cakupan'   => $request->jenis_cakupan,

            'diskon'          => $request->diskon,

            'status'          => $request->status,

            'tanggal_mulai'   => $request->tanggal_mulai,

            'tanggal_selesai' => $request->tanggal_selesai,
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
            'nama_promo' => 'required|string|max:255',

            'kode_promo' => [
                'required',
                'string',
                'max:50',
                Rule::unique('promos', 'kode_promo')->ignore($promo->id),
            ],

            // TAMBAHAN JENIS CAKUPAN
            'jenis_cakupan' => 'required|in:all,category,specific',

            'diskon' => 'required|numeric|min:1|max:100',

            'status' => 'required|in:aktif,nonaktif',

            'tanggal_mulai' => 'required|date',

            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $promo->update([
            'nama_promo'      => $request->nama_promo,

            'kode_promo'      => strtoupper($request->kode_promo),

            // TAMBAHAN JENIS CAKUPAN
            'jenis_cakupan'   => $request->jenis_cakupan,

            'diskon'          => $request->diskon,

            'status'          => $request->status,

            'tanggal_mulai'   => $request->tanggal_mulai,

            'tanggal_selesai' => $request->tanggal_selesai,
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