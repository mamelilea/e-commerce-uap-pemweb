<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        ProductCategory::insert([
            [
                'name' => 'Smartphone',
                'slug' => Str::slug('Smartphone'),
                'tagline' => 'Ponsel terbaru & canggih',
                'description' => 'Berbagai smartphone terbaru dengan fitur terkini',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Laptop',
                'slug' => Str::slug('Laptop'),
                'tagline' => 'Laptop cepat & ringan',
                'description' => 'Laptop untuk pekerjaan, gaming, dan kreativitas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Audio',
                'slug' => Str::slug('Audio'),
                'tagline' => 'Suara jernih & kuat',
                'description' => 'Headphone, speaker, dan aksesoris audio premium',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Aksesoris',
                'slug' => Str::slug('Aksesoris'),
                'tagline' => 'Tambahan untuk gadgetmu',
                'description' => 'Charger, kabel, case, dan aksesoris lain',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
