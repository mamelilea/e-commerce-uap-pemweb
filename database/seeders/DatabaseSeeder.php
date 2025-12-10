<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
        ]);

        $this->call([
            UserSeeder::class,              // 1. User dulu (owner toko)
            StoreSeeder::class,             // 2. Store (butuh user_id)
            ProductCategorySeeder::class,   // 3. Category
            ProductSeeder::class,           // 4. Product (butuh store_id & category_id)
            ProductImageSeeder::class,      // 5. Product Images (butuh product_id)
        ]);
    }
}