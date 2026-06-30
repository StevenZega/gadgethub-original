<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->role == 'admin') {
            return redirect('/admin/dashboard');
        }

        $products = Product::where('stock', '>', 0);

        // Search
        if ($request->search) {
            $products->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('brand', 'like', '%' . $request->search . '%');
            });
        }

        // Filter category (Sudah Diperbaiki agar fleksibel)
        if ($request->category) {
            if (strtolower($request->category) == 'handphone') {
                // Jika user pilih 'Handphone', sistem otomatis mencari 'Handphone', 'Smartphone', atau 'Hape'
                $products->whereIn('category', ['Handphone', 'Smartphone', 'Hape']);
            } else {
                $products->where('category', $request->category);
            }
        }

        // Sorting
        switch ($request->sort) {
            case 'price_asc':
                $products->orderBy('price', 'asc');
                break;

            case 'price_desc':
                $products->orderBy('price', 'desc');
                break;

            case 'name_asc':
                $products->orderBy('name', 'asc');
                break;

            case 'name_desc':
                $products->orderBy('name', 'desc');
                break;

            default:
                $products->latest();
                break;
        }
        
        $products = $products->get();

        return view('user.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::with('reviews.user')->findOrFail($id);
        $seller = User::where('role', 'admin')->first();

        // Hitung rata-rata rating
        $averageRating = $product->reviews->avg('rating') ?? 0;

        return view('user.show', compact('product', 'seller', 'averageRating'));
    }

    public function searchProducts(Request $request)
    {
        $search = $request->search;

        $products = Product::where(function($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%");
        })
        ->take(5)
        ->get();

        return response()->json($products);
    }

    public function myProfile()
    {
        // Mengambil data user yang saat ini sedang login
        $user = Auth::user();
        
        // Mengarahkan ke file view khusus profil user biasa
        return view('user.profile', compact('user'));
    }

    // Fungsi untuk memproses perubahan profil dari form user
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validasi data inputan
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
        ]);

        // Menyimpan data perubahan teks
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;

        // Logika Handle Upload Foto Profil Baru
        if ($request->hasFile('photo')) {
            // Hapus foto lama di folder storage jika ada sebelumnya
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            // Simpan foto baru ke folder storage/app/public/profiles
            $path = $request->file('photo')->store('profiles', 'public');
            $user->photo = $path;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil Anda berhasil diperbarui!');
    }

    // Simpan data ulasan baru ke database dari user
    public function storeReview(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $productId,
            'rating' => $request->rating,
            'comment' => $request->comment ?? '',
        ]);

        return redirect()->back()->with('success', 'Terima kasih, ulasan Anda berhasil disimpan!');
    }

    // Menampilkan halaman profil khusus Admin
    public function adminProfile()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    // Memproses update data profil Admin
    public function updateAdminProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;

        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            $path = $request->file('photo')->store('profiles', 'public');
            $user->photo = $path;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil Admin berhasil diperbarui!');
    }
}