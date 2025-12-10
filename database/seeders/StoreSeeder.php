<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Store;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        $stores = [
            [
                'user_id' => 2, // Pemilik Toko Elektronik
                'name' => 'Toko Elektronik Central',
                'logo' => 'stores/logo-elektronik.png', // Path dummy
                'about' => 'Toko elektronik terlengkap dengan harga terjangkau. Menjual smartphone, laptop, dan aksesoris elektronik.',
                'phone' => '081234567890',
                'address_id' => 'ADR001',
                'city' => 'Jakarta',
                'address' => 'Jl. Sudirman No. 123, Jakarta Pusat',
                'postal_code' => '10220',
                'is_verified' => true,
            ],
            [
                'user_id' => 3, // Pemilik Toko Fashion
                'name' => 'Fashion House',
                'logo' => 'stores/logo-fashion.png',
                'about' => 'Pusat fashion terkini untuk pria dan wanita. Koleksi lengkap pakaian, sepatu, dan aksesoris.',
                'phone' => '081234567891',
                'address_id' => 'ADR002',
                'city' => 'Bandung',
                'address' => 'Jl. Braga No. 45, Bandung',
                'postal_code' => '40111',
                'is_verified' => true,
            ],
            [
                'user_id' => 4, // Pemilik Toko Kesehatan
                'name' => 'Healthy Life Store',
                'logo' => 'stores/logo-kesehatan.png',
                'about' => 'Toko kesehatan terpercaya. Menyediakan vitamin, suplemen, alat kesehatan, dan produk organik.',
                'phone' => '081234567892',
                'address_id' => 'ADR003',
                'city' => 'Surabaya',
                'address' => 'Jl. Pemuda No. 78, Surabaya',
                'postal_code' => '60271',
                'is_verified' => true,
            ],
        ];

        foreach ($stores as $store) {
            Store::create($store);
        }
    }
}
