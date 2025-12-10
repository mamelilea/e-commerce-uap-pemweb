<?php

namespace Database\Seeders;

use App\Models\Product;
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
    }
    
}

$this->call([
    ProductCategorySeeder::class,
    ProductSeeder::class,
    AdminUserSeeder::class,
    UserSeeder::class,
    StoreSeeder::class,
    StoreBalanceSeeder::class,
    StoreBalanceHistorySeeder::class,
    TransactionSeeder::class,
    TransactionDetailSeeder::class,
    ProductImageSeeder::class,
]);
