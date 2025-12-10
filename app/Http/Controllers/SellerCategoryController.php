<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SellerCategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::with('parent')
            ->orderBy('name')
            ->paginate(10);

        return view('seller.categories.index', compact('categories'));
    }

    public function create()
    {
        $parents = ProductCategory::orderBy('name')->get();

        return view('seller.categories.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'slug'        => ['nullable', 'string', 'max:255', 'unique:product_categories,slug'],
            'tagline'     => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'parent_id'   => ['nullable', 'exists:product_categories,id'],
        ]);

        $validated['slug'] = Str::slug($validated['slug'] ?? $validated['name']);

        ProductCategory::create($validated);

        return redirect()
            ->route('seller.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(ProductCategory $category)
    {
        $parents = ProductCategory::where('id', '!=', $category->id)
            ->orderBy('name')
            ->get();

        return view('seller.categories.edit', compact('category', 'parents'));
    }

    public function update(Request $request, ProductCategory $category)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'slug'        => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('product_categories', 'slug')->ignore($category->id),
            ],
            'tagline'     => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'parent_id'   => ['nullable', 'exists:product_categories,id'],
        ]);

        if (($validated['parent_id'] ?? null) === $category->id) {
            return back()
                ->withErrors(['parent_id' => 'Kategori induk tidak boleh sama dengan kategori ini.'])
                ->withInput();
        }

        $validated['slug'] = Str::slug($validated['slug'] ?? $validated['name']);

        $category->update($validated);

        return redirect()
            ->route('seller.categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(ProductCategory $category)
    {
        $category->delete();

        return redirect()
            ->route('seller.categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}