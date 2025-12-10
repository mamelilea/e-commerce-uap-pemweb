<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * GET /api/products
     * List semua produk (homepage)
     */
    public function index()
    {
        $products = Product::with([
            'productCategory:id,name,slug',
            'store:id,name',
            'productImages' => function ($q) {
                $q->select('id','product_id','image','is_thumbnail')
                  ->where('is_thumbnail', true);
            }
        ])
        ->latest()
        ->get();

        return response()->json([
            'status' => 'success',
            'data' => $products
        ]);
    }

    /**
     * GET /api/products/category/{slug}
     * List produk berdasarkan kategori
     */
    public function byCategory($slug)
    {
        $category = ProductCategory::where('slug', $slug)->first();

        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kategori tidak ditemukan'
            ], 404);
        }

        $products = Product::with([
            'productCategory:id,name,slug',
            'store:id,name',
            'productImages' => function ($q) {
                $q->select('id','product_id','image','is_thumbnail')
                  ->where('is_thumbnail', true);
            }
        ])
        ->where('product_category_id', $category->id)
        ->latest()
        ->get();

        return response()->json([
            'status' => 'success',
            'category' => $category->name,
            'data' => $products
        ]);
    }

    /**
     * GET /api/products/{slug}
     * Detail satu produk
     */
    public function show($slug)
    {
        $product = Product::with([
            'productCategory:id,name,slug',
            'store:id,name,city',
            'productImages:id,product_id,image,is_thumbnail',
            'productReviews' => function ($q) {
                $q->select('id', 'product_id', 'rating', 'review', 'created_at')
                  ->with('transaction.buyer.user:id,name');
            }
        ])
        ->where('slug', $slug)
        ->first();

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        $averageRating = $product->productReviews->avg('rating');

        return response()->json([
            'status' => 'success',
            'data' => $product,
            'average_rating' => $averageRating
        ]);
    }
    /**
     * GET /produk/{slug}
     * Halaman detail produk (View)
     */
    public function detail($slug)
    {
        $product = Product::with([
            'productCategory',
            'store',
            'productImages',
            'productReviews.transaction.buyer.user'
        ])
        ->where('slug', $slug)
        ->firstOrFail();

        return view('user.detail', compact('product'));
    }
}
