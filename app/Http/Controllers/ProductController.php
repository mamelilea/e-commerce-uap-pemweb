<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(\App\Services\ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function show($id)
    {
        $product = \App\Models\Product::with(['productImages', 'store', 'productCategory'])->findOrFail($id);
        
        $relatedProducts = $this->productService->getRelatedProducts($product->id);

        return view('frontend.product.show', compact('product', 'relatedProducts'));
    }
}
