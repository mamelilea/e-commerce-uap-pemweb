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
                'id' => 1,
                'parent_id' => null,
                'image' => 'electronics.jpg',
                'name' => 'Electronics',
                'slug' => 'electronics',
                'tagline' => 'Electronic goods and accessories',
                'description' => 'All kinds of electronic products.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'parent_id' => 1,
                'image' => 'smartphone.jpg',
                'name' => 'Smartphones',
                'slug' => 'smartphones',
                'tagline' => 'Latest smartphones',
                'description' => 'Various smartphone devices.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}