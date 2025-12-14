<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $categories = \App\Models\ProductCategory::whereNull('parent_id')
                        ->with('children')
                        ->latest()
                        ->get();

        return view('frontend.store.categories.index', compact('categories'));
    }

    public function create()
    {
        $parentCategories = \App\Models\ProductCategory::whereNull('parent_id')->get();
        return view('frontend.store.categories.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:product_categories,id',
            'tagline' => 'nullable|string|max:255',
            'description' => 'required|string',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . uniqid(),
            'parent_id' => $request->parent_id,
            'tagline' => $request->tagline,
            'description' => $request->description,
        ];

        \App\Models\ProductCategory::create($data);

        return redirect()->route('seller.categories.index')->with('success', 'Category created successfully!');
    }

    public function edit($id)
    {
        $category = \App\Models\ProductCategory::findOrFail($id);
        $parentCategories = \App\Models\ProductCategory::whereNull('parent_id')
                            ->where('id', '!=', $id)
                            ->get();
        
        return view('frontend.store.categories.edit', compact('category', 'parentCategories'));
    }

    public function update(Request $request, $id)
    {
        $category = \App\Models\ProductCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:product_categories,id',
            'tagline' => 'nullable|string|max:255',
            'description' => 'required|string',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . uniqid(),
            'parent_id' => $request->parent_id,
            'tagline' => $request->tagline,
            'description' => $request->description,
        ];

        $category->update($data);

        return redirect()->route('seller.categories.index')->with('success', 'Category updated successfully!');
    }

    public function destroy($id)
    {
        $category = \App\Models\ProductCategory::findOrFail($id);
        $category->delete();

        return back()->with('success', 'Category deleted successfully!');
    }
}
