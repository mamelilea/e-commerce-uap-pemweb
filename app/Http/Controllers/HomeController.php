<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display homepage with hero and featured products
     */
    public function index()
    {
        // Get featured/latest products (8 products)
        $featuredProducts = Product::with(['store', 'productImages', 'productReviews'])
            ->where('stock', '>', 0)
            ->latest()
            ->take(4)
            ->get();

        // Get main categories (for hero category cards)
        $mainCategories = ProductCategory::whereNull('parent_id')
            ->withCount('products')
            ->take(5)
            ->get();

        return view('home', compact('featuredProducts', 'mainCategories'));
    }
}
