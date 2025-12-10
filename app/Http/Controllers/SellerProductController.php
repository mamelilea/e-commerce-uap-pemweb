<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SellerProductController extends Controller
{
    // List produk milik toko
    public function index()
    {
        $store = Auth::user()->store;

        if (!$store) {
            return back()->with('error', 'Anda belum memiliki toko.');
        }

        $products = Product::where('store_id', $store->id)->get();
        return view('toko.products.index', compact('products'));
    }

    // Form tambah produk
    public function create()
    {
        $categories = \App\Models\ProductCategory::all();
        return view('toko.products.create', compact('categories'));
    }

    // Simpan produk baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|image|max:2048',
            'product_category_id' => 'required|exists:product_categories,id',
        ]);

        // Generate slug otomatis
        $validated['slug'] = Str::slug($request->name);

        // Tambahkan store_id
        $validated['store_id'] = Auth::user()->store->id;

        // Simpan gambar jika ada
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // Simpan ke database
        Product::create($validated);

        return redirect()->route('toko.products.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    // Edit produk
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = \App\Models\ProductCategory::all();
        return view('toko.products.edit', compact('product', 'categories'));
    }

    // Update produk
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|numeric|min:0',
            'image'       => 'nullable|image|max:2048',
            'product_category_id' => 'required|exists:product_categories,id',
        ]);

        // Update slug jika nama berubah
        if ($request->name !== $product->name) {
            $validated['slug'] = Str::slug($request->name);
        } else {
            $validated['slug'] = $product->slug;
        }

        // Update gambar jika ada gambar baru
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        } else {
            $validated['image'] = $product->image; // Pertahankan gambar lama
        }

        // Update produk
        $product->update($validated);

        return redirect()->route('toko.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    // Hapus produk
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return back()->with('success', 'Produk berhasil dihapus.');
    }
}
