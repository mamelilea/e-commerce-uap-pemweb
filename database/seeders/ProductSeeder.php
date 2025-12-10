<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Store;
use App\Models\ProductCategory;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // ambil toko pertama (hasil StoreSeeder)
        $store = Store::first();
        if (!$store) {
            $this->command->warn('Seeder Product dibatalkan: tidak ada store.');
            return;
        }

        // ambil semua kategori (hasil ProductCategorySeeder)
        $categories = ProductCategory::all()->keyBy('slug');
        if ($categories->count() < 1) {
            $this->command->warn('Seeder Product dibatalkan: tidak ada product categories.');
            return;
        }

        $products = [
            // RUNNING
            [
                'category_slug' => 'sepatu-running',
                'name' => 'Nike Air Zoom Pegasus 40',
                'description' => 'Sepatu running ringan dengan cushioning responsif.',
                'condition' => 'new',
                'price' => 1599000,
                'weight' => 800, // gram
                'stock' => 15,
            ],
            [
                'category_slug' => 'sepatu-running',
                'name' => 'Adidas Ultraboost Light',
                'description' => 'Sepatu lari dengan bantalan Boost yang empuk.',
                'condition' => 'new',
                'price' => 2399000,
                'weight' => 850,
                'stock' => 10,
            ],

            // CASUAL
            [
                'category_slug' => 'sepatu-casual',
                'name' => 'Vans Old Skool Classic',
                'description' => 'Sepatu casual iconic untuk gaya harian.',
                'condition' => 'new',
                'price' => 899000,
                'weight' => 900,
                'stock' => 20,
            ],
            [
                'category_slug' => 'sepatu-casual',
                'name' => 'Converse Chuck Taylor All Star',
                'description' => 'Sneakers casual berbahan kanvas yang timeless.',
                'condition' => 'new',
                'price' => 799000,
                'weight' => 950,
                'stock' => 18,
            ],

            // BASKET
            [
                'category_slug' => 'sepatu-basket',
                'name' => 'Air Jordan 1 Mid',
                'description' => 'Sepatu basket dengan ankle support stabil.',
                'condition' => 'new',
                'price' => 1999000,
                'weight' => 1100,
                'stock' => 8,
            ],
            [
                'category_slug' => 'sepatu-basket',
                'name' => 'Nike LeBron Witness 7',
                'description' => 'Sepatu basket dengan grip kuat dan cushion tebal.',
                'condition' => 'new',
                'price' => 1699000,
                'weight' => 1200,
                'stock' => 9,
            ],

            // FUTSAL
            [
                'category_slug' => 'sepatu-futsal',
                'name' => 'Specs Accelerator Lightspeed',
                'description' => 'Sepatu futsal lokal dengan sol anti slip.',
                'condition' => 'new',
                'price' => 549000,
                'weight' => 700,
                'stock' => 25,
            ],
            [
                'category_slug' => 'sepatu-futsal',
                'name' => 'Nike Tiempo Legend 10 Futsal',
                'description' => 'Kontrol bola maksimal untuk futsal indoor.',
                'condition' => 'new',
                'price' => 1299000,
                'weight' => 750,
                'stock' => 12,
            ],

            // HIKING
            [
                'category_slug' => 'sepatu-hiking',
                'name' => 'Eiger Rhinos Mid Hiking',
                'description' => 'Sepatu hiking tangguh untuk medan berat.',
                'condition' => 'new',
                'price' => 999000,
                'weight' => 1400,
                'stock' => 7,
            ],
            [
                'category_slug' => 'sepatu-hiking',
                'name' => 'Salomon Speedcross 6 Trail',
                'description' => 'Sepatu trail dengan grip agresif di tanah berlumpur.',
                'condition' => 'new',
                'price' => 2199000,
                'weight' => 1300,
                'stock' => 6,
            ],
        ];

        foreach ($products as $p) {
            $category = $categories[$p['category_slug']] ?? null;

            if (!$category) continue;

            Product::create([
                'store_id' => $store->id,
                'product_category_id' => $category->id,
                'name' => $p['name'],
                'slug' => Str::slug($p['name']),
                'description' => $p['description'],
                'condition' => $p['condition'],
                'price' => $p['price'],
                'weight' => $p['weight'],
                'stock' => $p['stock'],
            ]);
        }
    }
}
