<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['store', 'productImages', 'productCategory'])
            ->withAvg('productReviews', 'rating')
            ->withCount('productReviews');

        $categoryName = 'All Products';
        
        if ($request->has('category') && $request->category) {
            $slug = $request->category;
            $category = ProductCategory::where('slug', $slug)->first();
            
            if ($category) {
                $query->where('product_category_id', $category->id);
                $categoryName = $category->name;
            }
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $user = Auth::user();
        if ($user && $user->store) {
            $query->where('store_id', '!=', $user->store->id);
        }

        $products = $query->latest()->paginate(12)->withQueryString();

        return Inertia::render('Products/Index', [
            'products' => $products,
            'categoryName' => $categoryName,
            'filters' => $request->only(['search', 'category']),
        ]);
    }

    public function show($slug)
    {
        $product = Product::with([
            'store', 
            'productImages', 
            'productCategory',
            'productReviews.transaction.buyer.user' 
        ])
        ->withCount('productReviews') 
        ->withAvg('productReviews', 'rating') 
        ->withSum('transactionDetails', 'qty') 
        ->where('slug', $slug)
        ->firstOrFail();

        if ($product->productReviews) {
            $product->productReviews->transform(function ($review) {
                $user = $review->transaction->buyer->user ?? null;
                
                $review->user = $user ? [
                    'name' => $user->name,
                    'avatar' => null
                ] : ['name' => 'Pengguna', 'avatar' => null];
                
                unset($review->transaction); 
                return $review;
            });
        }

        $storeRating = Product::where('store_id', $product->store_id)
            ->join('product_reviews', 'products.id', '=', 'product_reviews.product_id')
            ->avg('product_reviews.rating');

        $relatedProducts = Product::with(['productImages', 'store'])
            ->withAvg('productReviews', 'rating')
            ->withCount('productReviews')
            ->where('product_category_id', $product->product_category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        $canReview = false;
        $user = Auth::user();

        if ($user && $user->role === 'member') {
            $buyer = \App\Models\Buyer::where('user_id', $user->id)->first();
            
            if ($buyer) {
                $hasPurchased = \App\Models\Transaction::where('buyer_id', $buyer->id)
                ->whereIn('payment_status', ['paid', 'done'])
                    ->whereHas('transactionDetails', function ($q) use ($product) {
                        $q->where('product_id', $product->id);
                    })
                    ->exists();

                $alreadyReviewed = \App\Models\ProductReview::where('product_id', $product->id)
                    ->whereHas('transaction', function ($q) use ($buyer) {
                        $q->where('buyer_id', $buyer->id);
                    })
                    ->exists();

                $canReview = $hasPurchased && !$alreadyReviewed;
            }
        }

        return Inertia::render('Products/Detail', [
            'product' => $product,
            'storeRating' => round($storeRating, 1) ?? 0,
            'relatedProducts' => $relatedProducts,
            'canReview' => $canReview,
        ]);
    }
}