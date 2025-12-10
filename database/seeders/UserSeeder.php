<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        
        User::create([
            'name' => 'Member Satu',
            'email' => 'member1@example.com',
            'password' => Hash::make('password123'),
            'role' => 'member',
        ]);

        User::create([
            'name' => 'Member Dua',
            'email' => 'member2@example.com',
            'password' => Hash::make('password123'),
            'role' => 'member',
        ]);
    }
}
