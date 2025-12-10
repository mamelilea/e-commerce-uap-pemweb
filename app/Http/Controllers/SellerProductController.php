<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Store;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class SellerProductController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $store = Store::where('user_id', $user->id)->first();

        if (!$store) {
            return redirect()->route('seller.dashboard');
        }

        $query = Product::with(['productCategory', 'productImages'])
            ->where('store_id', $store->id);

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Seller/Products/Index', [
            'products' => $products,
            'filters' => $request->only(['search']),
        ]);
    }

    public function create()
    {
        $categories = ProductCategory::all();

        return Inertia::render('Seller/Products/Create', [
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $store = Store::where('user_id', $user->id)->first();

        $request->validate([
            'name' => 'required|string|max:255',
            'product_category_id' => 'required|exists:product_categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'weight' => 'required|integer|min:0',
            'condition' => 'required|in:new,second',
            'description' => 'required|string',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        DB::transaction(function () use ($request, $store) {
            $product = Product::create([
                'store_id' => $store->id,
                'product_category_id' => $request->product_category_id,
                'name' => $request->name,
                'slug' => Str::slug($request->name) . '-' . Str::random(5),
                'description' => $request->description,
                'condition' => $request->condition,
                'price' => $request->price,
                'weight' => $request->weight,
                'stock' => $request->stock,
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $path = $image->store('product-images', 'public');
                    
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $path,
                        'is_thumbnail' => $index === 0 ? 1 : 0,
                    ]);
                }
            }
        });

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $user = Auth::user();
        $store = Store::where('user_id', $user->id)->first();
        
        $product = Product::where('store_id', $store->id)
            ->with(['productImages', 'productCategory'])
            ->findOrFail($id);

        $categories = ProductCategory::all();

        return Inertia::render('Seller/Products/Edit', [
            'product' => $product,
            'categories' => $categories
        ]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'product_category_id' => 'required|exists:product_categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'weight' => 'required|integer|min:0',
            'condition' => 'required|in:new,second',
            'description' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        DB::transaction(function () use ($request, $product) {
            $product->update([
                'product_category_id' => $request->product_category_id,
                'name' => $request->name,
                'slug' => Str::slug($request->name) . '-' . Str::random(5),
                'description' => $request->description,
                'condition' => $request->condition,
                'price' => $request->price,
                'weight' => $request->weight,
                'stock' => $request->stock,
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('product-images', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $path,
                        'is_thumbnail' => false,
                    ]);
                }
            }
        });

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $product = Product::with('productImages')->findOrFail($id);

        foreach ($product->productImages as $img) {
            Storage::disk('public')->delete($img->image);
        }

        $product->productImages()->delete();
        $product->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus.');
    }

    public function destroyImage($id)
    {
        $image = ProductImage::findOrFail($id);
        
        Storage::disk('public')->delete($image->image);
        
        $image->delete();

        return redirect()->back()->with('success', 'Gambar berhasil dihapus.');
    }
}