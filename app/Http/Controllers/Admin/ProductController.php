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
        // FILTER: Hanya mengambil produk milik admin yang sedang login
        $products = Product::where('admin_id', auth()->id())->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function show($id)
    {
        // FILTER: Pastikan admin tidak bisa mengintip ID produk milik admin lain lewat URL
        $product = Product::where('admin_id', auth()->id())->findOrFail($id);
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
            'image'            => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'ram'              => 'nullable|integer',
            'storage'          => 'nullable|integer',
            'battery_capacity' => 'nullable|integer',
            'processor'        => 'nullable|string',
            'phone_processor'  => 'nullable|string', 
            'laptop_processor' => 'nullable|string', 
            'rear_camera'      => 'nullable|string',
            'screen_size'      => 'nullable|string',
            'os'               => 'nullable|string',
            'vga'              => 'nullable|string',
        ]);

        $data['processor'] = $request->processor ?: ($request->phone_processor ?: $request->laptop_processor);

        try {
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('products', 'public');
            }

            unset($data['phone_processor'], $data['laptop_processor']);

            // SUNTIK DATA: Daftarkan id admin yang sedang login ke produk ini
            $data['admin_id'] = auth()->id();

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
        // PROTEKSI: Jika admin mencoba mengedit produk milik admin lain, tolak otomatis
        if ($product->admin_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengedit produk ini.');
        }

        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        if ($product->admin_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah produk ini.');
        }

        $validatedData = $request->validate([
            'name'             => 'required|string|max:255',
            'category'         => 'required|string',
            'brand'            => 'required|string',
            'price'            => 'required|integer|min:0',
            'stock'            => 'required|integer|min:0',
            'description'      => 'required|string',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', 
            'ram'              => 'nullable|integer',
            'storage'          => 'nullable|integer',
            'battery_capacity' => 'nullable|integer',
            'processor'        => 'nullable|string', 
            'rear_camera'      => 'nullable|string',
            'screen_size'      => 'nullable|string',
            'os'               => 'nullable|string',
            'vga'              => 'nullable|string',
        ]);

        if ($request->has('phone_processor') || $request->has('laptop_processor')) {
            $validatedData['processor'] = $request->phone_processor ?: $request->laptop_processor;
        }

        try {
            if ($request->hasFile('image')) {
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }
                $validatedData['image'] = $request->file('image')->store('products', 'public');
            } else {
                $validatedData['image'] = $product->image;
            }

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
        if ($product->admin_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus produk ini.');
        }

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