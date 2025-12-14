<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    private function getSellerStoreId()
    {
        $store = Auth::user()->store;

        if (!$store) {
            return redirect()->route('seller.store.register')->send();
        }

        return $store->id;
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function index()
    {
        $storeId = $this->getSellerStoreId();
        $products = Product::where('store_id', $storeId)->with('category', 'images')->paginate(10);

        return view('seller.product.index', compact('products'));
    }

    public function create()
    {
        $categories = ProductCategory::pluck('name', 'id');
        return view('seller.product.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $storeId = $this->getSellerStoreId();

        $validated = $request->validate([
            'product_category_id' => 'required|exists:product_categories,id', // Harus ada kategori
            'name' => 'required|string|max:255',
            'about' => 'required|string',
            'condition' => 'required|in:new,used',
            'price' => 'required|numeric|min:1',
            'weight' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'images' => 'required|array|min:1',
            'images.*' => 'image|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $product = Product::create([
                'store_id' => $storeId,
                'product_category_id' => $validated['product_category_id'],
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
                'about' => $validated['about'],
                'condition' => $validated['condition'],
                'price' => $validated['price'],
                'weight' => $validated['weight'],
                'stock' => $validated['stock'],
            ]);

            $isThumbnailSet = false;
            $productImagesData = [];

            foreach ($request->file('images') as $index => $imageFile) {
                $path = $imageFile->store('product_images', 'public');

                $is_thumbnail = (!$isThumbnailSet) ? true : false;
                if ($is_thumbnail) {
                    $isThumbnailSet = true;
                }

                $productImagesData[] = new ProductImage([
                    'image' => 'storage/' . $path,
                    'is_thumbnail' => $is_thumbnail,
                ]);
            }

            $product->images()->saveMany($productImagesData);

            DB::commit();

            return redirect()->route('seller.products.index')->with('success', 'Hore! Produk baru berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($productImagesData)) {
                foreach ($productImagesData as $img) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $img->image));
                }
            }
            return redirect()->back()->with('error', 'Yah.. Gagal menambahkan produk. Cek input dan coba lagi. (Error: ' . $e->getMessage() . ')')->withInput();
        }
    }

    public function show(Product $product)
    {
        if ($product->store_id != $this->getSellerStoreId()) {
            abort(403);
        }
        return view('seller.product.show', compact('product'));
    }

    public function edit(Product $product)
    {
        if ($product->store_id != $this->getSellerStoreId()) {
            abort(403);
        }
        $categories = ProductCategory::pluck('name', 'id');
        return view('seller.product.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        if ($product->store_id != $this->getSellerStoreId()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'product_category_id' => 'required|exists:product_categories,id',
            'about' => 'required|string',
            'price' => 'required|numeric|min:1',
            'stock' => 'required|integer|min:0',
            'condition' => 'required|in:new,used',
            'weight' => 'required|integer|min:1',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $product->update([
            'product_category_id' => $validated['product_category_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'about' => $validated['about'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'condition' => $validated['condition'],
            'weight' => $validated['weight'],
        ]);

        if ($request->hasFile('images')) {
            $product->images()->delete();
            foreach ($request->file('images') as $key => $imageFile) {
                $path = $imageFile->store('products', 'public');
                $product->images()->create([
                    'image' => 'storage/' . $path,
                    'is_thumbnail' => ($key === 0),
                ]);
            }
        }

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        if ($product->store_id != $this->getSellerStoreId()) {
            abort(403);
        }

        foreach ($product->images as $image) {
            Storage::disk('public')->delete(str_replace('storage/', '', $image->image));
        }

        $product->images()->delete();
        $product->delete();

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil dihapus!');
    }
}
