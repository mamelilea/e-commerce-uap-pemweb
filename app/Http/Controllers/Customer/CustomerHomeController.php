<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\Product;

class CustomerHomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = ProductCategory::orderBy('name')->get();

        $productQuery = Product::query()->with(['category', 'images'])->latest();

        if ($request->filled('category')) {
            $productQuery->where('product_category_id', $request->category);
        }

        $products = $productQuery->paginate(12)->withQueryString();

        return view('customer.home', compact('categories', 'products'));
    }

    public function show($id)
    {
        $product = Product::with(['category', 'thumbnail', 'images', 'productReviews.user'])->findOrFail($id);
        return view('customer.product_detail', compact('product'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('q');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $sort = $request->input('sort');

        $products = Product::with(['thumbnail', 'images', 'category'])
            ->where(function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                      ->orWhere('description', 'like', '%' . $keyword . '%')
                      ->orWhereHas('category', function ($subQuery) use ($keyword) {
                          $subQuery->where('name', 'like', '%' . $keyword . '%');
                      });
            });

        if ($minPrice) {
            $products->where('price', '>=', $minPrice);
        }
        if ($maxPrice) {
            $products->where('price', '<=', $maxPrice);
        }

        if ($sort == 'price_asc') {
            $products->orderBy('price', 'asc');
        } elseif ($sort == 'price_desc') {
            $products->orderBy('price', 'desc');
        } elseif ($sort == 'name_asc') {
            $products->orderBy('name', 'asc');
        } else {
            $products->latest();
        }

        $products = $products->paginate(12);

        return view('customer.search', [
            'products' => $products,
            'keyword' => $keyword
        ]);
    }
}