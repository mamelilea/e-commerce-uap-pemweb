<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('stores')->insert([
    [
        'user_id' => 1, // pastikan user_id = 1 ada di tabel users
        'name' => 'Default Store',
        'slug' => 'default-store',
        'province' => 'DKI Jakarta',

        'logo' => 'default.png', // bebas, tapi WAJIB ADA
        'about' => 'Toko resmi yang menyediakan berbagai produk berkualitas.',
        'phone' => '08123456789',

        'address_id' => 'ADD123', // atau bebas, asal string
        'city' => 'Jakarta',
        'address' => 'Jl. Contoh No. 123',
        'postal_code' => '12345',

        'is_verified' => true,
        'created_at' => now(),
        'updated_at' => now(),
    ]
]);
    }
}