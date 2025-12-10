<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductImage;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        ProductImage::truncate();
        ProductImage::insert([
            // Produk 1 - Samsung Galaxy S23 Ultra
            [
                'product_id'   => 1,
                'image'        => 'img/products/samsung-galaxy-s23-ultra.png',
                'is_thumbnail' => true,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'product_id'   => 1,
                'image'        => 'img/products/samsung-galaxy-s23-ultra-2.png',
                'is_thumbnail' => false,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],

            // Produk 2 - MacBook Air M2
            [
                'product_id'   => 2,
                'image'        => 'img/products/macbook-air-m2-13-inch.png',
                'is_thumbnail' => true,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],

            // Produk 3 - Sony WH-1000XM5
            [
                'product_id'   => 3,
                'image'        => 'img/products/sony-wh-1000xm5.png',
                'is_thumbnail' => true,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],

            // Produk 4 - Baseus GaN 65W Charger
            [
                'product_id'   => 4,
                'image'        => 'img/products/baseus-gan-65w-charger.jpg',
                'is_thumbnail' => true,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);
    }
}
