<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@marketplace.com',
                'email_verified_at' => now(),
                'role' => 'admin', // ← Tambahan role
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Pemilik Toko Elektronik',
                'email' => 'elektronik@marketplace.com',
                'email_verified_at' => now(),
                'role' => 'seller', // ← Tambahan role
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Pemilik Toko Fashion',
                'email' => 'fashion@marketplace.com',
                'email_verified_at' => now(),
                'role' => 'seller', // ← Tambahan role
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Pemilik Toko Kesehatan',
                'email' => 'kesehatan@marketplace.com',
                'email_verified_at' => now(),
                'role' => 'seller', // ← Tambahan role
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Buyer Test User',
                'email' => 'buyer@marketplace.com',
                'email_verified_at' => now(),
                'role' => 'customer', // ← Tambahan role (user biasa/pembeli)
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}