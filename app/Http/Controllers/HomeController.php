<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query()
            ->when($request->search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%')
                             ->orWhere('description', 'like', '%' . $search . '%');
            })
            ->when($request->category, function ($query, $categorySlug) {
                return $query->whereHas('productCategory', function ($q) use ($categorySlug) {
                    $q->where('slug', $categorySlug);
                });
            })
            ->when($request->sort_by, function ($query, $sortBy) {
                if ($sortBy == 'price_asc') {
                    return $query->orderBy('price', 'asc');
                } elseif ($sortBy == 'price_desc') {
                    return $query->orderBy('price', 'desc');
                }
                return $query->latest();
            }, function ($query) {
                return $query->latest();
            })
            ->paginate(12);
            
        $categories = ProductCategory::all();
        return view('home.index', compact('products', 'categories'));
    }

    public function product(Product $product)
    {
        $product->load(['reviews.user', 'store']);
        return view('home.product', compact('product'));
    }

    public function checkout(Product $product)
    {
        return view('transaction.checkout', compact('product'));
    }

    public function history()
    {

        $user = auth()->user();

        $buyer = $user->buyer; 
        
        $transactions = collect();
        if ($buyer) {
            $transactions = \App\Models\Transaction::where('buyer_id', $buyer->id)->latest()->get();
        }
        
        return view('transaction.history', compact('transactions'));
    }
}
