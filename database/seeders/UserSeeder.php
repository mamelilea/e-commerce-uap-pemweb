<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin1@example.com'],
            [
                'name' => 'Admin 1',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );
    }
}
