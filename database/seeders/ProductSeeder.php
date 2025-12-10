<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Smartphones (kategori 2)
            [
                'store_id' => 1,
                'product_category_id' => 2,
                'name' => 'Samsung Galaxy A55',
                'slug' => 'samsung-galaxy-a55',
                'description' => 'Smartphone Samsung dengan layar AMOLED 6.5”, kamera 50MP, dan baterai 5000mAh.',
                'condition' => 'new',
                'price' => 4500000,
                'weight' => 500,
                'stock' => 20,
            ],
            [
                'store_id' => 1,
                'product_category_id' => 2,
                'name' => 'iPhone 15 Pro',
                'slug' => 'iphone-15-pro',
                'description' => 'iPhone 15 Pro dengan chip A17 Pro, kamera 48MP, dan layar Super Retina XDR.',
                'condition' => 'new',
                'price' => 15000000,
                'weight' => 600,
                'stock' => 10,
            ],

            // Electronics lainnya (kategori 1)
            [
                'store_id' => 1,
                'product_category_id' => 1,
                'name' => 'Laptop ASUS ROG',
                'slug' => 'laptop-asus-rog',
                'description' => 'Laptop gaming ASUS ROG dengan RTX 4060, RAM 16GB, dan SSD 512GB.',
                'condition' => 'new',
                'price' => 18000000,
                'weight' => 2500,
                'stock' => 5,
            ],
            [
                'store_id' => 1,
                'product_category_id' => 1,
                'name' => 'Headphone Sony WH-1000XM5',
                'slug' => 'sony-wh-1000xm5',
                'description' => 'Headphone noise-cancelling premium dari Sony.',
                'condition' => 'new',
                'price' => 5200000,
                'weight' => 350,
                'stock' => 12,
            ],
            [
                'store_id' => 1,
                'product_category_id' => 1,
                'name' => 'Smart TV LG 55 Inch 4K',
                'slug' => 'lg-55-4k-smart-tv',
                'description' => 'Smart TV LG 55” dengan panel 4K UHD dan webOS terbaru.',
                'condition' => 'new',
                'price' => 7500000,
                'weight' => 8000,
                'stock' => 8,
            ],
            [
                'store_id' => 1,
                'product_category_id' => 1,
                'name' => 'Logitech MX Master 3S',
                'slug' => 'logitech-mx-master-3s',
                'description' => 'Mouse profesional Logitech MX Master 3S dengan sensor presisi tinggi.',
                'condition' => 'new',
                'price' => 1500000,
                'weight' => 200,
                'stock' => 25,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
