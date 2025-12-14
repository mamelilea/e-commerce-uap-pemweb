<?php

namespace App\Interfaces;

interface ProductRepositoryInterface 
{
    public function getAllProducts();
    public function getProductBySlug($slug);
    public function getRelatedProducts($productId);
}
