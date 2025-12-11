<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
    [
        'store_id' => 1,
        'product_category_id' => 1,
        'name' => 'Matcha Birthday Cake',
        'slug' => Str::slug('Matcha Birthday Cake'),
        'description' => 'Kue ulang tahun rasa matcha dengan krim lembut dan aroma teh hijau premium.',
        'price' => 285000,
        'weight' => 1200,
        'condition' => 'new',   // WAJIB
        'stock' => 10,          // WAJIB
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'store_id' => 1,
        'product_category_id' => 2,
        'name' => 'Matcha Cookies',
        'slug' => Str::slug('Matcha Cookies'),
        'description' => 'Cookies matcha renyah dengan rasa manis seimbang.',
        'price' => 85000,
        'weight' => 500,
        'condition' => 'new',
        'stock' => 20,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'store_id' => 1,
        'product_category_id' => 3,
        'name' => 'Vanilla Cupcake',
        'slug' => Str::slug('Vanilla Cupcake'),
        'description' => 'Cupcake vanilla lembut dengan frosting krim susu.',
        'price' => 45000,
        'weight' => 150,
        'condition' => 'new',
        'stock' => 15,
        'created_at' => now(),
        'updated_at' => now(),
    ],
]);
    }
}   