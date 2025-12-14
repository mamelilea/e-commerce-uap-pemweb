<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellerProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $store = \App\Models\Store::where('user_id', auth()->id())->firstOrFail();
        $products = \App\Models\Product::with('productImages')->where('store_id', $store->id)->latest()->paginate(10);
        return view('frontend.store.product.index', compact('products'));
    }

    public function create()
    {
        return view('frontend.store.product.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'product_category_id' => 'required|exists:product_categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'condition' => 'required|in:new,used',
            'about' => 'required|string',
            'images.*' => 'nullable|image|max:2048', // Validate array of images
        ]);

        $store = \App\Models\Store::where('user_id', auth()->id())->firstOrFail();

        $product = \App\Models\Product::create([
            'store_id' => $store->id,
            'product_category_id' => $request->product_category_id,
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name . '-' . uniqid()),
            'price' => $request->price,
            'stock' => $request->stock,
            'condition' => $request->condition,
            'about' => $request->about,
            'weight' => 100, // Default weight
        ]);

        // Handle Multiple Image Upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                \App\Models\ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                    'is_thumbnail' => $index === 0, // First image is thumbnail
                ]);
            }
        }

        return redirect()->route('store.index')->with('success', 'Product added successfully!');
    }

    public function edit($id)
    {
        $store = \App\Models\Store::where('user_id', auth()->id())->firstOrFail();
        $product = \App\Models\Product::with('productImages')->where('store_id', $store->id)->where('id', $id)->firstOrFail();

        return view('frontend.store.product.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $store = \App\Models\Store::where('user_id', auth()->id())->firstOrFail();
        $product = \App\Models\Product::where('store_id', $store->id)->where('id', $id)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'product_category_id' => 'required|exists:product_categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'condition' => 'required|in:new,used',
            'about' => 'required|string',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $product->update([
            'product_category_id' => $request->product_category_id,
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'condition' => $request->condition,
            'about' => $request->about,
        ]);

        if ($request->hasFile('images')) {
            $hasThumbnail = $product->productImages()->where('is_thumbnail', true)->exists();
            
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                \App\Models\ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                    'is_thumbnail' => !$hasThumbnail, // Set as thumbnail if none exists
                ]);
                $hasThumbnail = true;
            }
        }

        return redirect()->route('seller.products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $store = \App\Models\Store::where('user_id', auth()->id())->firstOrFail();
        $product = \App\Models\Product::where('store_id', $store->id)->where('id', $id)->firstOrFail();

        // Delete all images
        foreach ($product->productImages as $image) {
             \Illuminate\Support\Facades\Storage::disk('public')->delete($image->image);
             $image->delete();
        }

        $product->delete();

        return back()->with('success', 'Product deleted successfully!');
    }

    public function destroyImage($id)
    {
        $store = \App\Models\Store::where('user_id', auth()->id())->firstOrFail();
        // Ensure the image belongs to a product owned by the store
        $image = \App\Models\ProductImage::whereHas('product', function($query) use ($store) {
            $query->where('store_id', $store->id);
        })->where('id', $id)->firstOrFail();

        \Illuminate\Support\Facades\Storage::disk('public')->delete($image->image);
        $image->delete();

        // If we deleted the thumbnail, promote another image to thumbnail
        if ($image->is_thumbnail) {
            $newThumbnail = \App\Models\ProductImage::where('product_id', $image->product_id)->first();
            if ($newThumbnail) {
                $newThumbnail->update(['is_thumbnail' => true]);
            }
        }

        return back()->with('success', 'Image removed successfully!');
    }
}
