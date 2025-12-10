<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;
use Illuminate\Support\Str;

class ProductCategorySeeder extends Seeder
{
    public function run()
    {
        // Kategori induk
        $parentCategories = [
            ['name' => 'Elektronik', 'tagline' => 'Gadget & Aksesoris'],
            ['name' => 'Pakaian', 'tagline' => 'Fashion & Busana'],
            ['name' => 'Kesehatan', 'tagline' => 'Produk Kesehatan'],
            ['name' => 'Olahraga', 'tagline' => 'Peralatan & Pakaian Olahraga'],
        ];

        foreach ($parentCategories as $parent) {
            $parentCategory = ProductCategory::create([
                'name' => $parent['name'],
                'slug' => Str::slug($parent['name']),
                'tagline' => $parent['tagline'],
                'description' => fake()->paragraph(),
                'image' => 'default-category.png', // ganti sesuai kebutuhan
                'parent_id' => null,
            ]);

            // Buat beberapa subkategori untuk tiap induk
            for ($i = 1; $i <= 3; $i++) {
                $subName = $parent['name'] . ' Sub ' . $i;
                ProductCategory::create([
                    'name' => $subName,
                    'slug' => Str::slug($subName),
                    'tagline' => $parent['tagline'],
                    'description' => fake()->paragraph(),
                    'image' => 'default-category.png',
                    'parent_id' => $parentCategory->id,
                ]);
            }
        }

        ProductCategory::create([
            'name' => 'Bunga Asli',
            'slug' => 'bunga-asli',
            'tagline' => 'Produk Bunga Asli',
            'description' => 'Bunga Asli yang langsung ditanam pada kebun kami, sehingga terjamin kualitasnya.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        ProductCategory::create([
            'name' => 'Buket Bunga',
            'slug' => 'buket-bunga',
            'tagline' => 'Produk Buket Bunga',
            'description' => 'Bunga yang dihias menjadi suatu buket yang indah. Dapat diisi dengan bunga asli ataupun bunga imitasi.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        ProductCategory::create([
            'name' => 'Papan Bunga',
            'slug' => 'papan-bunga',
            'tagline' => 'Produk Papan Bunga',
            'description' => 'Rangkaian bunga yang dibentuk menjadi sebuah papan karangan. ',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
