<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('product_categories')->insert([
            [
                'name' => 'Birthday Cake',
                'slug' => Str::slug('Birthday Cake'),
                'description' => 'Kue ulang tahun custom dengan berbagai varian rasa'
            ],
            [
                'name' => 'Cookies',
                'slug' => Str::slug('Cookies'),
                'description' => 'Cookies renyah dengan bahan premium'
            ],
            [
                'name' => 'Cupcake',
                'slug' => Str::slug('Cupcake'),
                'description' => 'Cupcake lembut dengan topping menarik'
            ],
            [
                'name' => 'Pastry',
                'slug' => Str::slug('Pastry'),
                'description' => 'Pastry fresh dibuat setiap hari'
            ],
        ]);
    }
}