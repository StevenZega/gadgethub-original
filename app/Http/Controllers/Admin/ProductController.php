<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'             => 'required|string|max:255',
            'category'         => 'required|string',
            'brand'            => 'required|string',
            'price'            => 'required|integer|min:0',
            'stock'            => 'required|integer|min:0',
            'description'      => 'required|string',
            
            // Saat bikin baru gambar wajib dimasukkan
            'image'            => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',

            'ram'              => 'nullable|integer',
            'storage'          => 'nullable|integer',
            'battery_capacity' => 'nullable|integer',
            
            // Name di form HTML create & edit sudah seragam menggunakan 'processor'
            'processor'        => 'nullable|string',
            
            'rear_camera'      => 'nullable|string',
            'screen_size'      => 'nullable|string',
            'os'               => 'nullable|string',
            'vga'              => 'nullable|string',
        ]);

        try {
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('products', 'public');
            }

            Product::create($data);

            return redirect()->route('products.index')->with('success', 'Product created successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error_gagal' => 'Gagal menyimpan produk: ' . $e->getMessage()]);
        }
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        // Validasi Data (Mengubah image menjadi 'nullable' agar jika dikosongkan tidak memicu error)
        $validatedData = $request->validate([
            'name'             => 'required|string|max:255',
            'category'         => 'required|string',
            'brand'            => 'required|string',
            'price'            => 'required|integer|min:0',
            'stock'            => 'required|integer|min:0',
            'description'      => 'required|string',
            
            // Diubah ke nullable agar kalau dikosongkan tidak memicu error required
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', 

            'ram'              => 'nullable|integer',
            'storage'          => 'nullable|integer',
            'battery_capacity' => 'nullable|integer',
            
            // Sinkronisasi penuh menggunakan field 'processor' murni dari form edit blade
            'processor'        => 'nullable|string', 
            
            'rear_camera'      => 'nullable|string',
            'screen_size'      => 'nullable|string',
            'os'               => 'nullable|string',
            'vga'              => 'nullable|string',
        ]);

        try {
            // Logika Berkas Gambar (Hanya berjalan jika admin mengunggah foto baru)
            if ($request->hasFile('image')) {
                // Hapus berkas foto lama dari sistem penyimpanan agar server hemat space
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }
                // Simpan berkas foto yang baru masuk
                $validatedData['image'] = $request->file('image')->store('products', 'public');
            } else {
                // JIKA tidak ganti foto, amankan path foto lama agar tidak hilang dari database
                $validatedData['image'] = $product->image;
            }

            // Eksekusi pembaruan ke database
            $product->update($validatedData);

            return redirect()->route('products.index')->with('success', 'Product updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error_gagal' => 'Gagal memperbarui produk: ' . $e->getMessage()]);
        }
    }

    public function destroy(Product $product)
    {
        try {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $product->delete();

            return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
            
        } catch (\Exception $e) {
            return redirect()->route('products.index')->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }
}