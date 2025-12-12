<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Users
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@sillia.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        
        $seller1 = User::create([ // Owner of Urban Style
            'name' => 'Lia',
            'email' => 'lia@sillia.com',
            'password' => Hash::make('password'),
            'role' => 'member', // Will become seller when store created
        ]);
        
        $seller2 = User::create([ // Owner of Chic Boutique
            'name' => 'silla',
            'email' => 'silla@sillia.com',
            'password' => Hash::make('password'),
            'role' => 'member',
        ]);

        $buyer = User::create([
            'name' => 'jabok',
            'email' => 'jabok@sillia.com',
            'password' => Hash::make('password'),
            'role' => 'member',
        ]);

        // Init User Balances
        \App\Models\UserBalance::create(['user_id' => $admin->id, 'balance' => 0]);
        \App\Models\UserBalance::create(['user_id' => $seller1->id, 'balance' => 500000]);
        \App\Models\UserBalance::create(['user_id' => $seller2->id, 'balance' => 0]);
        \App\Models\UserBalance::create(['user_id' => $buyer->id, 'balance' => 2000000]); // Rich buyer

        // 2. Create Stores
        $FlawlessStore = \App\Models\Store::create([
            'user_id' => $seller1->id,
            'name' => 'Flawless Store',
            'logo' => 'stores/default.png',
            'about' => 'Your daily dose of flawless beauty products.',
            'phone' => '08123456789',
            'address_id' => '1',
            'city' => 'Sidoarjo',
            'address' => 'Jl. Tunjungan No. 10',
            'postal_code' => '12730',
            'is_verified' => true,
        ]);

        $BeePrettyStore = \App\Models\Store::create([
            'user_id' => $seller2->id,
            'name' => 'Bee Pretty',
            'logo' => 'stores/default.png',
            'about' => 'Be pretty, be you. Collection for every occasion.',
            'phone' => '08198765432',
            'address_id' => '2',
            'city' => 'Surabaya',
            'address' => 'Jl. puri indah No. 88',
            'postal_code' => '40132', 
            'is_verified' => true,
        ]);

        // Init Store Balances
        \App\Models\StoreBalance::create(['store_id' => $FlawlessStore->id, 'balance' => 0]);
        \App\Models\StoreBalance::create(['store_id' => $BeePrettyStore->id, 'balance' => 0]);

        // 3. Create Categories & Products (Via ProductSeeder)
        $this->call(ProductSeeder::class);
    }
}
