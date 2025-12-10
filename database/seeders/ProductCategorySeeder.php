<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Fresh Fruit',
                'slug' => 'fresh-fruit',
                'tagline' => 'Buah segar langsung dari kebun',
                'description' => 'Pilihan buah-buahan organik segar untuk kebutuhan nutrisi harian Anda.',
                'image' => 'images/Icon/FreshFruit.svg' 
            ],
            [
                'name' => 'Vegetables',
                'slug' => 'vegetables',
                'tagline' => 'Sayuran hijau bebas pestisida',
                'description' => 'Sayur mayur segar yang dipanen setiap pagi dari petani lokal.',
                'image' => 'images/Icon/Vegetables.svg'
            ],
            [
                'name' => 'Fresh Meat',
                'slug' => 'fresh-meat',
                'tagline' => 'Daging segar kualitas premium',
                'description' => 'Daging sapi, ayam, dan ikan segar pilihan yang higienis.',
                'image' => 'images/Icon/FreshMeat.svg'
            ],
            [
                'name' => 'Health Drink',
                'slug' => 'health-drink',
                'tagline' => 'Minuman sehat dan menyegarkan',
                'description' => 'Jus buah asli, susu murni, dan minuman herbal penambah imun.',
                'image' => 'images/Icon/HealthyDrink.svg'
            ],
        ];

        foreach ($categories as $category) {
            ProductCategory::create($category);
        }
    }
}