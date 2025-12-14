<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::paginate(10);
        return view('seller.category.index', compact('categories'));
    }

    public function create()
    {
        return view('seller.category.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:product_categories,name',
            'tagline' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('categories', 'public');
            $validated['image'] = 'storage/' . $path;
        }

        ProductCategory::create($validated);

        return redirect()->route('seller.categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function show(ProductCategory $category)
    {
        return redirect()->route('seller.categories.edit', $category);
    }

    public function edit(ProductCategory $category)
    {
        return view('seller.category.edit', compact('category'));
    }

    public function update(Request $request, ProductCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:product_categories,name,' . $category->id,
            'tagline' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('image')) {
            if ($category->image) {
                $oldImagePath = str_replace('storage/', '', $category->image);
                Storage::disk('public')->delete($oldImagePath);
            }

            $path = $request->file('image')->store('categories', 'public');
            $validated['image'] = 'storage/' . $path;
        }

        $category->update($validated);

        return redirect()->route('seller.categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(ProductCategory $category)
    {
        if ($category->products()->exists()) {
            return redirect()->route('seller.categories.index')
                ->with('error', 'Tidak dapat menghapus kategori karena masih memiliki produk.');
        }

        if ($category->image) {
            $imagePath = str_replace('storage/', '', $category->image);
            Storage::disk('public')->delete($imagePath);
        }

        $category->delete();

        return redirect()->route('seller.categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
