<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Buat admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Buat beberapa seller
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => 'Seller ' . $i,
                'email' => 'seller' . $i . '@example.com',
                'password' => Hash::make('password'),
                'role' => 'seller',
            ]);
        }

        // Buat beberapa member/buyer
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => 'Member ' . $i,
                'email' => 'member' . $i . '@example.com',
                'password' => Hash::make('password'),
                'role' => 'member',
            ]);
        }
    }
}
