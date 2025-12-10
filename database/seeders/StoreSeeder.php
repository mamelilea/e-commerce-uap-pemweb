<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Store;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        Store::insert([
            [
                'user_id'     => 1,
                'name'        => 'GadgetHub Official Store',
                'slug'        => Str::slug('GadgetHub Official Store'),
                'logo'        => 'stores/store1.png',
                'about'       => 'Toko gadget terpercaya menjual smartphone, laptop, audio, dan aksesoris.',
                'phone'       => '081234567890',
                'address_id'  => 'ADDR-001',
                'city'        => 'Jakarta Selatan',
                'address'     => 'Jl. Sudirman No. 11',
                'postal_code' => '12940',
                'is_verified' => true,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'user_id'     => 2,
                'name'        => 'TechZone Premium',
                'slug'        => Str::slug('TechZone Premium'),
                'logo'        => 'stores/store2.png',
                'about'       => 'Menjual perangkat teknologi premium dan original.',
                'phone'       => '082233445566',
                'address_id'  => 'ADDR-002',
                'city'        => 'Bandung',
                'address'     => 'Jl. Dago No. 77',
                'postal_code' => '40135',
                'is_verified' => true,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]
        ]);
    }
}
