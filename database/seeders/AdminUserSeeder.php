<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Jika user id = 1 belum ada, buat admin baru
        $admin = User::firstOrCreate(
            ['id' => 1], // paksa ID 1 agar foreign key tidak error
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        // Jika user id 1 sudah ada, pastikan role jadi admin
        $admin->update(['role' => 'admin']);
    }
}
