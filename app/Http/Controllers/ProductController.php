<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($id)
    {
        // Ambil produk dengan relasi yang dibutuhkan
        $product = Product::with([
            'productImages',           // Gambar produk
            'productCategory',         // Kategori produk
            'store.user',             // Toko dan pemiliknya
            // 'reviews.user'          // Uncomment jika sudah ada fitur review
        ])->findOrFail($id);

        // Ambil produk terkait dari kategori yang sama
        $relatedProducts = Product::where('product_category_id', $product->product_category_id)
            ->where('id', '!=', $product->id)       // Exclude produk yang sedang dilihat
            ->where('stock', '>', 0)                // Hanya yang masih ada stok
            ->with(['productImages', 'store'])      // Eager load relasi
            ->limit(4)                              // Maksimal 4 produk
            ->get();

        return view('detailProduct', compact('product', 'relatedProducts'));
    }

    public function create()
    {
        $categories = ProductCategory::all();
        return view('seller.products.create', compact('categories'));
    }

    /**
     * Simpan produk baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'condition' => 'required|in:new,second',
            'price' => 'required|numeric|min:0',
            'weight' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'product_category_id' => 'required|exists:product_categories,id',
        ]);

        $validated['store_id'] = auth()->user()->store->id;
        $validated['slug'] = Str::slug($validated['name']) . '-' . uniqid();

        Product::create($validated);

        return redirect()->route('seller.products.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    /**
     * Form edit produk.
     */
    public function edit(Product $product)
    {
        $this->authorizeProduct($product);

        $categories = ProductCategory::all();
        return view('seller.products.edit', compact('product', 'categories'));
    }

    /**
     * Update produk.
     */
    public function update(Request $request, Product $product)
    {
        $this->authorizeProduct($product);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'condition' => 'required|in:new,second',
            'price' => 'required|numeric|min:0',
            'weight' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'product_category_id' => 'required|exists:product_categories,id',
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . uniqid();

        $product->update($validated);

        return redirect()->route('seller.products.index')
            ->with('success', 'Produk berhasil diupdate');
    }

    /**
     * Hapus produk.
     */
    public function destroy(Product $product)
    {
        $this->authorizeProduct($product);

        $product->delete();

        return redirect()->route('seller.products.index')
            ->with('success', 'Produk berhasil dihapus');
    }

    /**
     * Helper untuk memastikan produk milik store seller.
     */
    private function authorizeProduct(Product $product)
    {
        if ($product->store_id !== auth()->user()->store->id) {
            abort(403, 'Anda tidak berhak mengakses produk ini');
        }
    }
}
