<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;
use Illuminate\Support\Str;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Sepatu Running',
                'image' => 'categories/sepatu-running.png',
                'tagline' => 'Nyaman untuk lari jauh',
                'description' => 'Kategori sepatu khusus lari dengan bantalan empuk dan ringan.',
            ],
            [
                'name' => 'Sepatu Casual',
                'image' => 'categories/sepatu-casual.png',
                'tagline' => 'Santai tapi tetap stylish',
                'description' => 'Kategori sepatu casual untuk aktivitas harian dan nongkrong.',
            ],
            [
                'name' => 'Sepatu Basket',
                'image' => 'categories/sepatu-basket.png',
                'tagline' => 'Stabil dan responsif',
                'description' => 'Kategori sepatu basket dengan grip kuat dan ankle support.',
            ],
            [
                'name' => 'Sepatu Futsal',
                'image' => 'categories/sepatu-futsal.png',
                'tagline' => 'Grip maksimal di lapangan',
                'description' => 'Kategori sepatu futsal untuk lapangan indoor/outdoor.',
            ],
            [
                'name' => 'Sepatu Hiking',
                'image' => 'categories/sepatu-hiking.png',
                'tagline' => 'Tangguh di segala medan',
                'description' => 'Kategori sepatu hiking/trail dengan sol kuat dan anti slip.',
            ],
        ];

        foreach ($categories as $cat) {
            ProductCategory::create([
                'parent_id'   => null,
                'image'       => $cat['image'],
                'name'        => $cat['name'],
                'slug'        => Str::slug($cat['name']),
                'tagline'     => $cat['tagline'],
                'description' => $cat['description'],
            ]);
        }
    }
}
