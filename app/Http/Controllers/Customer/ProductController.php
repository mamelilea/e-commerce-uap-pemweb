<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Halaman Detail Produk
    public function show($slug)
    {
        $product = Product::with([
            'store',
            'productCategory',
            'productImages',
            'productReviews.user'
        ])->where('slug', $slug)->firstOrFail();

        $averageRating = $product->productReviews()->avg('rating') ?? 0;
        $totalReviews = $product->productReviews()->count();

        return view('products.detail', compact('product', 'averageRating', 'totalReviews'));
    }
}