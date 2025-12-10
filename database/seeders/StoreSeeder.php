<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Store;
use App\Models\User;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        // ambil salah satu member (member pertama)
        $member = User::where('role', 'member')->first();

        // kalau belum ada member, stop biar gak error
        if (!$member) {
            $this->command->warn('Seeder Store dibatalkan: tidak ada user role member.');
            return;
        }

        Store::create([
            'user_id' => $member->id,
            'name' => 'Toko Member Pertama',
            'logo' => 'logos/toko1.png', 
            'about' => 'Toko ini milik salah satu member.',
            'phone' => '081234567890',
            'city' => 'Jakarta',
            'address' => 'Jl. Contoh No. 123',
            'postal_code' => '12345',
            'is_verified' => true,
        ]);
    }
}