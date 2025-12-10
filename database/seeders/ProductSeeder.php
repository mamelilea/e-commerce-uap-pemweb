<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::insert([
            [
                'store_id' => 1,
                'product_category_id' => 1,
                'name' => 'Samsung Galaxy S23 Ultra',
                'slug' => Str::slug('Samsung Galaxy S23 Ultra'),
                'description' => 'Smartphone flagship dengan kamera 200MP dan performa tinggi.',
                'condition' => 'new',
                'price' => 18999000,
                'weight' => 650,
                'stock' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'store_id' => 1,
                'product_category_id' => 2,
                'name' => 'MacBook Air M2 13-inch',
                'slug' => Str::slug('MacBook Air M2 13-inch'),
                'description' => 'Laptop ringan dan cepat dengan chip Apple M2.',
                'condition' => 'new',
                'price' => 16999000,
                'weight' => 1200,
                'stock' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'store_id' => 2,
                'product_category_id' => 3,
                'name' => 'Sony WH-1000XM5',
                'slug' => Str::slug('Sony WH-1000XM5'),
                'description' => 'Headphone premium dengan ANC terbaik.',
                'condition' => 'new',
                'price' => 4999000,
                'weight' => 300,
                'stock' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'store_id' => 2,
                'product_category_id' => 4,
                'name' => 'Baseus GaN 65W Charger',
                'slug' => Str::slug('Baseus GaN 65W Charger'),
                'description' => 'Charger cepat berbasis GaN untuk semua device.',
                'condition' => 'new',
                'price' => 399000,
                'weight' => 150,
                'stock' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
