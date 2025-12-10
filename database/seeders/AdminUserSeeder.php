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
        User::where('id', 1)->update([
            'role' => 'admin'
        ]);

        // 2. (OPSIONAL) Buat admin baru jika mau
        // User::create([
        //     'name' => 'Second Admin',
        //     'email' => 'admin2@example.com',
        //     'password' => Hash::make('password123'),
        //     'role' => 'admin'
        // ]);

        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin'
            ]
        );
    }
}
