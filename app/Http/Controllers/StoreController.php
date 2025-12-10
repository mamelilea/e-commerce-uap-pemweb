<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StoreController extends Controller
{
    public function show(Request $request, $slug)
    {
        $store = Store::with(['user:id,name', 'products.productReviews'])
            ->where('name', $slug) 
            ->firstOrFail();

        $productsQuery = Product::where('store_id', $store->id)
            ->with(['productImages', 'store'])
            ->withAvg('productReviews', 'rating')
            ->withCount('productReviews');

        if ($request->has('search') && $request->search) {
            $productsQuery->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $productsQuery->paginate(12)->withQueryString();

        $storeRating = Product::where('store_id', $store->id)
            ->join('product_reviews', 'products.id', '=', 'product_reviews.product_id')
            ->avg('product_reviews.rating');

        return Inertia::render('Stores/Show', [
            'store' => [
                'id' => $store->id,
                'user_id' => $store->user_id,
                'name' => $store->name,
                'logo' => $store->logo,
                'about' => $store->about,
                'phone' => $store->phone,
                'address' => $store->address,
                'city' => $store->city,
                'user_name' => $store->user->name,
            ],
            'products' => $products,
            'storeRating' => round($storeRating, 1) ?? 0,
            'filters' => $request->only('search'),
        ]);
    }
}