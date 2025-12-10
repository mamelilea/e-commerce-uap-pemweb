<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@freshmart.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Juragan Sayur',
            'email' => 'seller@freshmart.com',
            'password' => Hash::make('password123'),
            'role' => 'seller',
        ]);

        User::create([
            'name' => 'Budi Pembeli',
            'email' => 'buyer@freshmart.com',
            'password' => Hash::make('password123'),
            'role' => 'member', 
        ]);
    }
}
