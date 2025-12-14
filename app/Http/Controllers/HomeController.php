<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $category = $request->query('category');

        // If category filter is active, show filtered products
        if ($category) {
            $query = \App\Models\Product::with(['productImages', 'store', 'productCategory']);
            
            $query->whereHas('productCategory', function($q) use ($category) {
                $q->where('slug', $category);
            });

            // Also apply search if provided
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('about', 'like', "%{$search}%");
                });
            }

            $products = $query->latest()->paginate(12);
            
            // Get category name for display
            $categoryName = \App\Models\ProductCategory::where('slug', $category)->value('name');
            
            return view('frontend.home', compact('products', 'search', 'category', 'categoryName'));
        }

        // Default view: Official and Fanmade split
        // 1. Official Merchandise (Album, Lightstick, Photocard)
        $officialCategories = ['Album', 'Lightstick', 'Photocard'];
        $officialProducts = \App\Models\Product::whereHas('productCategory', function($q) use ($officialCategories) {
            $q->whereIn('name', $officialCategories);
        })
        ->when($search, function($q) use ($search) {
            $q->where(function($subq) use ($search) {
                 $subq->where('name', 'like', "%{$search}%")
                      ->orWhere('about', 'like', "%{$search}%");
            });
        })
        ->with('productCategory')->inRandomOrder()->take(8)->get();

        // 2. Fanmade Merchandise (Apparel, Doll, Keychains & Stickers)
        $fanmadeCategoryNames = ['Apparel', 'Doll', 'Keychains & Stickers'];
        $fanmadeProducts = \App\Models\Product::whereHas('productCategory', function($q) use ($fanmadeCategoryNames) {
            $q->whereIn('name', $fanmadeCategoryNames);
        })
        ->when($search, function($q) use ($search) {
             $q->where(function($subq) use ($search) {
                 $subq->where('name', 'like', "%{$search}%")
                      ->orWhere('about', 'like', "%{$search}%");
            });
        })
        ->with('productCategory')->inRandomOrder()->take(8)->get();

        return view('frontend.home', compact('officialProducts', 'fanmadeProducts', 'search', 'category'));
    }
}
