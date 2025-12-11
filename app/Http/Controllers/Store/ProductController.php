<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // Menampilkan daftar produk
    public function index()
    {
        $store = Auth::user()->store;
        $products = Product::where('store_id', $store->id)->paginate(10);
        
        return view('store.products.index', compact('products'));
    }

    // Menampilkan form tambah produk
    public function create()
    {
        $store = Auth::user()->store;
        $categories = ProductCategory::where('store_id', $store->id)->get();
        
        return view('store.products.create', compact('categories'));
    }

    // Menyimpan produk baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:product_categories,id',
        ]);

        $store = Auth::user()->store;

        Product::create([
            'store_id' => $store->id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'status' => 'active'
        ]);

        return redirect()->route('store.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    // Menampilkan form edit produk
    public function edit(Product $product)
    {
        // Cek apakah produk milik toko ini
        if ($product->store_id !== Auth::user()->store->id) {
            abort(403); // Forbidden
        }

        $categories = ProductCategory::where('store_id', Auth::user()->store->id)->get();
        
        return view('store.products.edit', compact('product', 'categories'));
    }

    // Update produk
    public function update(Request $request, Product $product)
    {
        if ($product->store_id !== Auth::user()->store->id) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:product_categories,id',
        ]);

        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return redirect()->route('store.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    // Hapus produk
    public function destroy(Product $product)
    {
        if ($product->store_id !== Auth::user()->store->id) {
            abort(403);
        }

        $product->delete();

        return redirect()->route('store.products.index')->with('success', 'Produk berhasil dihapus!');
    }
}