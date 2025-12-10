<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua kategori dengan jumlah produk
        $categories = ProductCategory::whereNull('parent_id')
            ->withCount('products')
            ->orderBy('name')
            ->get();

        // Query produk dengan relasi
        $query = Product::with(['productCategory', 'store']);

        // Filter berdasarkan kategori
        if ($request->has('category') && $request->category != '') {
            $query->where('product_category_id', $request->category);
        }

        // Filter berdasarkan pencarian
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        // Filter berdasarkan kondisi (new/used)
        if ($request->has('condition') && $request->condition != '') {
            $query->where('condition', $request->condition);
        }

        // Hanya tampilkan produk yang ada stoknya
        $products = $query->where('stock', '>', 0)
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('dashboard', compact('products', 'categories'));
    }
}