<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminProfileController extends Controller
{
    public function index()
    {
        $setting = auth()->user()->storeSetting;

        return view('admin.profile.index', compact('setting'));
    }

    public function edit()
    {
        $setting = StoreSetting::where('user_id', auth()->id())->first();

        return view('admin.profile.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.Auth::id(), // Validasi email unik kecuali milik sendiri
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'store_location' => 'nullable',
            'bank_account' => 'nullable',
            'qris_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            $user->photo = $request->file('photo')->store('profiles', 'public');   
        }
        $user->save();

        // Ambil setting milik user yang sedang login saat ini (pasti aman & tidak tertukar)
        $setting = StoreSetting::firstOrNew(['user_id' => $user->id]);

        $setting->store_location = $request->store_location;
        $setting->bank_account = $request->bank_account;

        // Proses pemindahan file QRIS hanya jika user mengunggah file baru
        if ($request->hasFile('qris_image')) {
            // Hapus file QRIS lama milik user ini jika ada agar storage bersih
            if ($setting->qris_image && file_exists(public_path($setting->qris_image))) {
                @unlink(public_path($setting->qris_image));
            }

            // Berikan nama unik menggunakan ID user agar file antar admin tidak tertukar di folder public
            $filename = 'qris_user_'.$user->id.'_'.time().'.'.$request->qris_image->extension();
            $request->qris_image->move(public_path('qris'), $filename);

            $setting->qris_image = 'qris/'.$filename;
        }

        $setting->save();

        return redirect()->route('admin.profile')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}