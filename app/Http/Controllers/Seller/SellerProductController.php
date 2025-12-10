<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SellerProductController extends Controller
{
    /**
     * Display a listing of the seller's products.
     */
    public function index()
    {
        $products = auth()->user()->store->products()
            ->with(['productCategory', 'productImages'])
            ->latest()
            ->paginate(10);

        return view('seller.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = ProductCategory::whereNull('parent_id')
            ->with('children')
            ->get();

        return view('seller.products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'weight' => 'required|integer|min:1',
            'product_category_id' => 'required|exists:product_categories,id',
            'condition' => 'required|in:new,second',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Create product
        $product = auth()->user()->store->products()->create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']) . '-' . Str::random(6),
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'weight' => $validated['weight'],
            'product_category_id' => $validated['product_category_id'],
            'condition' => $validated['condition'],
        ]);

        // Handle multiple image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                    'is_thumbnail' => $index === 0, // First image is thumbnail
                ]);
            }
        }

        return redirect()->route('seller.products.index')
            ->with('success', 'Product created successfully!');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit($id)
    {
        $product = auth()->user()->store->products()->findOrFail($id);
        
        $categories = ProductCategory::whereNull('parent_id')
            ->with('children')
            ->get();

        return view('seller.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, $id)
    {
        $product = auth()->user()->store->products()->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'weight' => 'required|integer|min:1',
            'product_category_id' => 'required|exists:product_categories,id',
            'condition' => 'required|in:new,second',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Prepare update data
        $updateData = [
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'weight' => $validated['weight'],
            'product_category_id' => $validated['product_category_id'],
            'condition' => $validated['condition'],
        ];

        // Only update slug if name has changed
        if ($product->name !== $validated['name']) {
            $updateData['slug'] = Str::slug($validated['name']) . '-' . Str::random(6);
        }

        // Update product
        $product->update($updateData);

        // Handle new image uploads
        $uploadedCount = 0;
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                    'is_thumbnail' => $product->productImages->count() === 0,
                ]);
                $uploadedCount++;
            }
        }

        $message = 'Product updated successfully!';
        if ($uploadedCount > 0) {
            $message .= " ($uploadedCount " . Str::plural('image', $uploadedCount) . " uploaded)";
        }

        return redirect()->route('seller.products.index')
            ->with('success', $message);
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy($id)
    {
        $product = auth()->user()->store->products()->findOrFail($id);

        // Delete product images from storage
        foreach ($product->productImages as $image) {
            Storage::disk('public')->delete($image->image);
            $image->delete();
        }

        // Delete product
        $product->delete();

        return redirect()->route('seller.products.index')
            ->with('success', 'Product deleted successfully!');
    }

    /**
     * Delete product image.
     */
    public function deleteImage($imageId)
    {
        $image = ProductImage::findOrFail($imageId);
        
        // Verify ownership
        if ($image->product->store_id !== auth()->user()->store->id) {
            abort(403);
        }

        // Delete from storage
        Storage::disk('public')->delete($image->image);
        $image->delete();

        return back()->with('success', 'Image deleted successfully!');
    }
}
