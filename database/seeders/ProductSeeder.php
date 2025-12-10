<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Store;
use App\Models\ProductCategory;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Ambil semua store dan kategori
        $stores = Store::all();
        $categories = ProductCategory::all();

        // Jika tidak ada store atau kategori, hentikan
        if ($stores->isEmpty() || $categories->isEmpty()) {
            $this->command->info('Tidak ada store atau kategori, seeding dibatalkan.');
            return;
        }

        // Membuat 50 produk contoh
        for ($i = 0; $i < 50; $i++) {
            $name = fake()->words(3, true); // misal "Kemeja Lengan Panjang"
            
            Product::create([
                'store_id' => $stores->random()->id,
                'product_category_id' => $categories->random()->id,
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => fake()->paragraph(),
                'condition' => fake()->randomElement(['new', 'used']),
                'price' => fake()->randomFloat(2, 10, 500), // harga antara 10 - 500
                'weight' => fake()->numberBetween(100, 5000), // berat dalam gram
                'stock' => fake()->numberBetween(0, 100),
            ]);
        }
    }
}
