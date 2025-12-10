<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SellerProductController extends Controller
{
    public function index(Request $request)
    {
        $store = $this->userStore($request);

        $products = $store->products()
            ->with(['productCategory', 'productImages'])
            ->latest()
            ->paginate(10);

        return view('seller.products.index', compact('products'));
    }

    public function create(Request $request)
    {
        $this->userStore($request);
        $categories = ProductCategory::orderBy('name')->get();

        return view('seller.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $store = $this->userStore($request);

        $validated = $request->validate([
            'product_category_id' => ['required', 'exists:product_categories,id'],
            'name'                => ['required', 'string', 'max:255'],
            'slug'                => ['nullable', 'string', 'max:255', 'unique:products,slug'],
            'description'         => ['required', 'string'],
            'condition'           => ['required', Rule::in(['new', 'second'])],
            'price'               => ['required', 'numeric', 'min:0'],
            'weight'              => ['required', 'integer', 'min:0'],
            'stock'               => ['required', 'integer', 'min:0'],
            'images.*'            => ['nullable', 'image', 'max:4096'],
        ]);

        $validated['slug'] = $this->generateSlug($validated['slug'] ?? $validated['name']);
        $validated['store_id'] = $store->id;

        $product = Product::create($validated);

        if ($request->hasFile('images')) {
            $this->storeImages($product, $request->file('images'));
        }

        return redirect()
            ->route('seller.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Request $request, Product $product)
    {
        $this->ensureProductOwner($request, $product);

        $categories = ProductCategory::orderBy('name')->get();
        $product->load(['productCategory', 'productImages']);

        return view('seller.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $this->ensureProductOwner($request, $product);

        $validated = $request->validate([
            'product_category_id' => ['required', 'exists:product_categories,id'],
            'name'                => ['required', 'string', 'max:255'],
            'slug'                => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('products', 'slug')->ignore($product->id),
            ],
            'description'         => ['required', 'string'],
            'condition'           => ['required', Rule::in(['new', 'second'])],
            'price'               => ['required', 'numeric', 'min:0'],
            'weight'              => ['required', 'integer', 'min:0'],
            'stock'               => ['required', 'integer', 'min:0'],
        ]);

        $validated['slug'] = $this->generateSlug($validated['slug'] ?? $validated['name'], $product->id);

        $product->update($validated);

        return redirect()
            ->route('seller.products.edit', $product)
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Request $request, Product $product)
    {
        $this->ensureProductOwner($request, $product);

        foreach ($product->productImages as $image) {
            Storage::disk('public')->delete($image->image);
        }

        $product->delete();

        return redirect()
            ->route('seller.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    public function storeImage(Request $request, Product $product)
    {
        $this->ensureProductOwner($request, $product);

        $data = $request->validate([
            'image'            => ['required', 'image', 'max:4096'],
            'set_as_thumbnail' => ['nullable', 'boolean'],
        ]);

        $path = $data['image']->store('product-images', 'public');

        $image = $product->productImages()->create([
            'image'        => $path,
            'is_thumbnail' => false,
        ]);

        $hasThumbnail = $product->productImages()->where('is_thumbnail', true)->exists();
        if (($data['set_as_thumbnail'] ?? false) || !$hasThumbnail) {
            $this->markAsThumbnail($product, $image);
        }

        return back()->with('success', 'Gambar berhasil ditambahkan.');
    }

    public function setThumbnail(Request $request, Product $product, ProductImage $image)
    {
        $this->ensureProductOwner($request, $product);
        $this->ensureImageBelongsToProduct($product, $image);

        $this->markAsThumbnail($product, $image);

        return back()->with('success', 'Thumbnail berhasil diperbarui.');
    }

    public function destroyImage(Request $request, Product $product, ProductImage $image)
    {
        $this->ensureProductOwner($request, $product);
        $this->ensureImageBelongsToProduct($product, $image);

        $wasThumbnail = $image->is_thumbnail;
        Storage::disk('public')->delete($image->image);
        $image->delete();

        if ($wasThumbnail) {
            $next = $product->productImages()->first();
            if ($next) {
                $this->markAsThumbnail($product, $next);
            }
        }

        return back()->with('success', 'Gambar berhasil dihapus.');
    }

    protected function userStore(Request $request)
    {
        return $request->user()->store()->firstOrFail();
    }

    protected function ensureProductOwner(Request $request, Product $product)
    {
        $store = $this->userStore($request);

        if ($product->store_id !== $store->id) {
            abort(403);
        }

        return $store;
    }

    protected function ensureImageBelongsToProduct(Product $product, ProductImage $image)
    {
        if ($image->product_id !== $product->id) {
            abort(404);
        }
    }

    protected function generateSlug(string $value, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($value) ?: 'produk';
        $slug     = $baseSlug;
        $counter  = 1;

        while (
            Product::where('slug', $slug)
                ->when($ignoreId, fn($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    protected function storeImages(Product $product, array $files): void
    {
        $createdImages = [];

        foreach ($files as $file) {
            if (!$file) {
                continue;
            }

            $path = $file->store('product-images', 'public');

            $createdImages[] = $product->productImages()->create([
                'image'        => $path,
                'is_thumbnail' => false,
            ]);
        }

        if (!empty($createdImages)) {
            $this->markAsThumbnail($product, $createdImages[0]);
        }
    }

    protected function markAsThumbnail(Product $product, ProductImage $image): void
    {
        $product->productImages()->update(['is_thumbnail' => false]);
        $image->update(['is_thumbnail' => true]);
    }
}