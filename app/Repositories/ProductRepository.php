<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface 
{
    public function getAllProducts() 
    {
        return Product::with(['store', 'productImages', 'productCategory'])->latest()->get();
    }

    public function getProductBySlug($slug) 
    {
        return Product::with(['store', 'productImages', 'productCategory', 'productReviews.transaction.user'])
                    ->where('slug', $slug)
                    ->firstOrFail();
    }

    public function getRelatedProducts($productId)
    {
         return Product::where('id', '!=', $productId)
                    ->inRandomOrder()
                    ->take(4)
                    ->get();
    }
}
