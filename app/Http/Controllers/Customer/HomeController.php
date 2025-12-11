<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('images', 'category');

        // Filter kategori
        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        // Search
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->get();

        $categories = ProductCategory::all();

        return view('Homepage.home', compact('products', 'categories'));
    }
}