<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Delete all existing categories
        ProductCategory::truncate();
        
        // Re-enable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Men Category
        $men = ProductCategory::create([
            'name' => 'Men',
            'slug' => 'men',
            'parent_id' => null,
            'image' => null,
            'tagline' => null,
            'description' => 'Men\'s fashion and accessories',
        ]);

        // Men Subcategories
        ProductCategory::create(['name' => 'Shirts', 'slug' => 'men-shirts', 'parent_id' => $men->id, 'description' => 'Men\'s shirts']);
        ProductCategory::create(['name' => 'Pants', 'slug' => 'men-pants', 'parent_id' => $men->id, 'description' => 'Men\'s pants']);
        ProductCategory::create(['name' => 'Jackets', 'slug' => 'men-jackets', 'parent_id' => $men->id, 'description' => 'Men\'s jackets']);
        ProductCategory::create(['name' => 'Shoes', 'slug' => 'men-shoes', 'parent_id' => $men->id, 'description' => 'Men\'s shoes']);
        ProductCategory::create(['name' => 'Accessories', 'slug' => 'men-accessories', 'parent_id' => $men->id, 'description' => 'Men\'s accessories']);

        // Women Category
        $women = ProductCategory::create([
            'name' => 'Women',
            'slug' => 'women',
            'parent_id' => null,
            'image' => null,
            'tagline' => null,
            'description' => 'Women\'s fashion and accessories',
        ]);

        // Women Subcategories
        ProductCategory::create(['name' => 'Dresses', 'slug' => 'women-dresses', 'parent_id' => $women->id, 'description' => 'Women\'s dresses']);
        ProductCategory::create(['name' => 'Tops', 'slug' => 'women-tops', 'parent_id' => $women->id, 'description' => 'Women\'s tops']);
        ProductCategory::create(['name' => 'Pants', 'slug' => 'women-pants', 'parent_id' => $women->id, 'description' => 'Women\'s pants']);
        ProductCategory::create(['name' => 'Shoes', 'slug' => 'women-shoes', 'parent_id' => $women->id, 'description' => 'Women\'s shoes']);
        ProductCategory::create(['name' => 'Accessories', 'slug' => 'women-accessories', 'parent_id' => $women->id, 'description' => 'Women\'s accessories']);

        echo "✅ Created 2 main categories (Men, Women) with 10 subcategories\n";
    }
}
