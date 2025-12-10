<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;

class HomepageController extends Controller
{
    public function allProducts(Request $request)
    {
        $products = $this->fetchProducts($request);

        return response()->json($products);
    }

    private function fetchProducts(Request $request)
    {
        $query = Product::with([
            'store',
            'productCategory',
            'productImages' => function ($q) {
                $q->where('is_thumbnail', true);
            },
        ]);

        // Search
        if ($request->search) {
            // DULU: product_name -> ini nggak ada di tabel
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter kategori (by slug)
        if ($request->category) {
            $query->whereHas('productCategory', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Min-Max price
        if ($request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        return $query->get();
    }

    // ============================================
    // HALAMAN UNTUK GUEST
    // ============================================
    public function indexGuest(Request $request)
    {
        $products = $this->fetchProducts($request);
        $categories = ProductCategory::all();

        return view('user.index', compact('products', 'categories'));
    }

    // ============================================
    // HALAMAN UNTUK USER LOGIN
    // ============================================
    public function indexAuth(Request $request)
    {
        $products = $this->fetchProducts($request);
        $categories = ProductCategory::all();

        return view('user.index', compact('products', 'categories'));
    }

    // ============================================
    // AMBIL PRODUK BERDASARKAN KATEGORI (AJAX)
    // ============================================
    public function getByCategory($slug)
    {
        $products = Product::with([
            'productCategory',
            'productImages' => function ($q) {
                $q->where('is_thumbnail', true);
            },
        ])
            ->whereHas('productCategory', function ($q) use ($slug) {
                $q->where('slug', $slug);
            })
            ->get();

        return response()->json($products);
    }
}
