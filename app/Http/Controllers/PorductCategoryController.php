<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    // Halaman Kategori - tampilkan semua produk dalam kategori ini
    public function show($slug)
    {
        $category = ProductCategory::where('slug', $slug)->firstOrFail();
        
        // Ambil produk dengan relasi yang dibutuhkan + pagination
        $products = $category->products()
            ->with(['store', 'productImages', 'productReviews'])
            ->paginate(12);

        return view('customer.category-products', compact('category', 'products'));
    }
}