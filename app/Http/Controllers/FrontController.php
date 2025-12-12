<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = \App\Models\Product::where('is_active', true)->whereHas('store', function($q) {
            $q->where('is_verified', true);
        });

        if ($request->has('search') && $request->search != '') {
             $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        if ($request->has('min_price') && $request->min_price != '') {
             $query->where('price', '>=', $request->min_price);
        }
        
        if ($request->has('max_price') && $request->max_price != '') {
             $query->where('price', '<=', $request->max_price);
        }

        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'lowest':
                    $query->orderBy('price', 'asc');
                    break;
                case 'highest':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
             $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = \App\Models\ProductCategory::all();

        return view('home', compact('products', 'categories'));
    }

    public function details($slug)
    {
        $product = \App\Models\Product::where('slug', $slug)->whereHas('store', function($q) {
            $q->where('is_verified', true);
        })->with(['store', 'productImages'])->firstOrFail();
        return view('product.details', compact('product'));
    }

    public function history()
    {
        $transactions = \App\Models\Transaction::where('buyer_id', \Illuminate\Support\Facades\Auth::id())
                        ->with('details.product')
                        ->orderBy('created_at', 'desc')
                        ->get();
                        
        return view('history', compact('transactions'));
    }

    public function collection(\Illuminate\Http\Request $request)
    {
        $query = \App\Models\Product::where('is_active', true)->whereHas('store', function($q) {
            $q->where('is_verified', true);
        });

        if ($request->has('category')) {
            $category = \App\Models\ProductCategory::where('slug', $request->category)->first();
            if ($category) {
                $query->where('product_category_id', $category->id);
            }
        }

        $products = $query->paginate(16);
        $categories = \App\Models\ProductCategory::all();
        return view('collection', compact('products', 'categories'));
    }

    public function lookbook()
    {
        return view('lookbook');
    }

    public function about()
    {
        return view('about');
    }
}
