<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of products
     */
    public function index(Request $request)
    {
        $query = Product::with(['store', 'productImages', 'productReviews', 'productCategory'])
            ->where('stock', '>', 0);

        // Category filter
        if ($request->filled('category')) {
            $catId = $request->category;
            $query->where(function($q) use ($catId) {
                $q->where('product_category_id', $catId)
                  ->orWhereHas('productCategory', function($subQ) use ($catId) {
                      $subQ->where('parent_id', $catId);
                  });
            });
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Price filter - support multiple ranges via checkboxes
        if ($request->filled('price_ranges')) {
            $ranges = is_array($request->price_ranges) ? $request->price_ranges : [$request->price_ranges];
            $query->where(function($q) use ($ranges) {
                foreach ($ranges as $range) {
                    $parts = explode('-', $range);
                    if (count($parts) === 2) {
                        $min = (int)$parts[0];
                        $max = (int)$parts[1];
                        if ($max === 0) {
                            // Unlimited max (e.g., 1000000-0 means >= 1000000)
                            $q->orWhere('price', '>=', $min);
                        } else {
                            $q->orWhere(function($subQ) use ($min, $max) {
                                $subQ->where('price', '>=', $min)->where('price', '<=', $max);
                            });
                        }
                    }
                }
            });
        }
        
        // Legacy support for old min/max price params (in case used elsewhere)
        if ($request->filled('min_price') && !$request->filled('price_ranges')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price') && !$request->filled('price_ranges')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sorting
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->latest();
        }


        $products = $query->paginate(12);
        
        // Fetch parent categories with their children and product counts
        $categories = ProductCategory::with(['children' => function($q) {
                $q->withCount('products');
            }])
            ->whereNull('parent_id')
            ->withCount('products')
            ->get();

        if ($request->ajax()) {
            return view('components.product-grid', compact('products'))->render();
        }

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Display the specified product
     */
    public function show($slug)
    {
        $product = Product::with([
            'store', 
            'productImages', 
            'productReviews.transaction.buyer',
            'productCategory'
        ])->where('slug', $slug)->firstOrFail();

        // Get related products from same category
        $relatedProducts = Product::with(['store', 'productImages', 'productReviews'])
            ->where('product_category_id', $product->product_category_id)
            ->where('id', '!=', $product->id)
            ->where('stock', '>', 0)
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Search products
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        $products = Product::with(['store', 'productImages', 'productReviews'])
            ->where('name', 'like', '%' . $query . '%')
            ->orWhere('description', 'like', '%' . $query . '%')
            ->where('stock', '>', 0)
            ->paginate(12);

        $categories = ProductCategory::whereNull('parent_id')->withCount('products')->get();

        return view('products.index', compact('products', 'categories', 'query'));
    }
}
