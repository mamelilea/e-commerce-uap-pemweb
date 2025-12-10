<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SellerProductController extends Controller
{
    /**
     * Display list of products
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $store = $user->store;

        if (!$store) {
            abort(403, 'You do not have a store.');
        }

        $query = Product::where('store_id', $store->id)
            ->with(['productCategory', 'productImages'])
            ->orderBy('created_at', 'desc');

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('product_category_id', $request->category);
        }

        // Filter by condition
        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        $products = $query->paginate(12);

        // Get categories for filter
        $categories = ProductCategory::orderBy('name')->get();

        // Statistics
        $stats = [
            'total_products' => Product::where('store_id', $store->id)->count(),
            'low_stock' => Product::where('store_id', $store->id)->where('stock', '<', 10)->count(),
            'out_of_stock' => Product::where('store_id', $store->id)->where('stock', 0)->count(),
        ];

        return view('seller.products.index', compact('products', 'categories', 'stats'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $user = Auth::user();
        $store = $user->store;

        if (!$store) {
            abort(403, 'You do not have a store.');
        }

        $categories = ProductCategory::orderBy('name')->get();

        return view('seller.products.create', compact('categories'));
    }

    /**
     * Store new product
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $store = $user->store;

        if (!$store) {
            abort(403, 'You do not have a store.');
        }

        $request->validate([
            'product_category_id' => ['required', 'exists:product_categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'condition' => ['required', 'in:new,second'],
            'price' => ['required', 'numeric', 'min:0'],
            'weight' => ['required', 'integer', 'min:1'],
            'stock' => ['required', 'integer', 'min:0'],
            'images' => ['required', 'array', 'min:1', 'max:2'],
            'images.*' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp'],
        ], [
            'images.required' => 'Minimal 1 gambar produk harus diupload',
            'images.max' => 'Maksimal 2 gambar per produk',
            'images.*.image' => 'File harus berupa gambar',
        ]);

        DB::beginTransaction();

        try {
            // Generate slug
            $slug = Str::slug($request->name . '-' . time());

            // Create product
            $product = Product::create([
                'store_id' => $store->id,
                'product_category_id' => $request->product_category_id,
                'name' => $request->name,
                'slug' => $slug,
                'description' => $request->description,
                'condition' => $request->condition,
                'price' => $request->price,
                'weight' => $request->weight,
                'stock' => $request->stock,
            ]);

            // Upload images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $imagePath = $image->store('product-images', 'public');

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $imagePath,
                        'is_thumbnail' => $index === 0, // First image as thumbnail
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('seller.products.index')
                ->with('success', 'Produk berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->withErrors([
                'error' => 'Terjadi kesalahan saat menambahkan produk: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $user = Auth::user();
        $store = $user->store;

        if (!$store) {
            abort(403, 'You do not have a store.');
        }

        $product = Product::where('store_id', $store->id)
            ->with('productImages')
            ->findOrFail($id);

        $categories = ProductCategory::orderBy('name')->get();

        return view('seller.products.edit', compact('product', 'categories'));
    }

    /**
     * Update product
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $store = $user->store;

        if (!$store) {
            abort(403, 'You do not have a store.');
        }

        $product = Product::where('store_id', $store->id)->findOrFail($id);

        $request->validate([
            'product_category_id' => ['required', 'exists:product_categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'condition' => ['required', 'in:new,second'],
            'price' => ['required', 'numeric', 'min:0'],
            'weight' => ['required', 'integer', 'min:1'],
            'stock' => ['required', 'integer', 'min:0'],
            'images' => ['nullable', 'array', 'max:2'],
            'images.*' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp'],
        ], [
            'images.max' => 'Maksimal 2 gambar per produk',
        ]);

        DB::beginTransaction();

        try {
            // Update slug if name changed
            if ($product->name !== $request->name) {
                $slug = Str::slug($request->name . '-' . time());
                $product->slug = $slug;
            }

            // Update product
            $product->update([
                'product_category_id' => $request->product_category_id,
                'name' => $request->name,
                'description' => $request->description,
                'condition' => $request->condition,
                'price' => $request->price,
                'weight' => $request->weight,
                'stock' => $request->stock,
            ]);

            // Upload new images if provided
            if ($request->hasFile('images')) {
                $currentImagesCount = $product->productImages()->count();
                $newImagesCount = count($request->file('images'));
                $totalImages = $currentImagesCount + $newImagesCount;

                if ($totalImages > 2) {
                    DB::rollBack();
                    return back()->withInput()->withErrors([
                        'images' => 'Total gambar tidak boleh lebih dari 2. Hapus gambar lama terlebih dahulu.'
                    ]);
                }

                foreach ($request->file('images') as $index => $image) {
                    $imagePath = $image->store('product-images', 'public');

                    // If this is first image and no thumbnail exists, set as thumbnail
                    $isThumbnail = !$product->productImages()->where('is_thumbnail', true)->exists();

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $imagePath,
                        'is_thumbnail' => $isThumbnail,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('seller.products.index')
                ->with('success', 'Produk berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->withErrors([
                'error' => 'Terjadi kesalahan saat memperbarui produk: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Delete product
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $store = $user->store;

        if (!$store) {
            abort(403, 'You do not have a store.');
        }

        $product = Product::where('store_id', $store->id)->findOrFail($id);

        DB::beginTransaction();

        try {
            // Delete all product images from storage
            foreach ($product->productImages as $productImage) {
                if (Storage::disk('public')->exists($productImage->image)) {
                    Storage::disk('public')->delete($productImage->image);
                }
            }

            // Delete product (will cascade delete images due to FK constraint)
            $product->delete();

            DB::commit();

            return redirect()->route('seller.products.index')
                ->with('success', 'Produk berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors([
                'error' => 'Terjadi kesalahan saat menghapus produk: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Delete single product image
     */
    public function deleteImage($productId, $imageId)
    {
        $user = Auth::user();
        $store = $user->store;

        if (!$store) {
            abort(403, 'You do not have a store.');
        }

        $product = Product::where('store_id', $store->id)->findOrFail($productId);
        $image = ProductImage::where('product_id', $product->id)->findOrFail($imageId);

        // Check if product has more than 1 image
        if ($product->productImages()->count() <= 1) {
            return back()->withErrors([
                'error' => 'Produk harus memiliki minimal 1 gambar.'
            ]);
        }

        $wasThumbnail = $image->is_thumbnail;

        // Delete from storage
        if (Storage::disk('public')->exists($image->image)) {
            Storage::disk('public')->delete($image->image);
        }

        // Delete from database
        $image->delete();

        // If deleted image was thumbnail, set first remaining image as thumbnail
        if ($wasThumbnail) {
            $firstImage = $product->productImages()->first();
            if ($firstImage) {
                $firstImage->is_thumbnail = true;
                $firstImage->save();
            }
        }

        return back()->with('success', 'Gambar berhasil dihapus!');
    }

    /**
     * Set image as thumbnail
     */
    public function setThumbnail($productId, $imageId)
    {
        $user = Auth::user();
        $store = $user->store;

        if (!$store) {
            abort(403, 'You do not have a store.');
        }

        $product = Product::where('store_id', $store->id)->findOrFail($productId);
        $image = ProductImage::where('product_id', $product->id)->findOrFail($imageId);

        // Reset all thumbnails
        ProductImage::where('product_id', $product->id)
            ->update(['is_thumbnail' => false]);

        // Set new thumbnail
        $image->is_thumbnail = true;
        $image->save();

        return back()->with('success', 'Thumbnail berhasil diubah!');
    }
}
