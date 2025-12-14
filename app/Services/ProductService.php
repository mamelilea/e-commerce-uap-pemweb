<?php

namespace App\Services;

use App\Interfaces\ProductRepositoryInterface;

class ProductService 
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getHomeProducts()
    {
        // Business logic can go here (e.g. filtering, caching)
        return $this->productRepository->getAllProducts()->take(8);
    }

    public function getProductDetails($slug)
    {
        return $this->productRepository->getProductBySlug($slug);
    }

    public function getRelatedProducts($productId)
    {
        return $this->productRepository->getRelatedProducts($productId);
    }
}
