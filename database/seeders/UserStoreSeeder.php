<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Store;

class UserStoreSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('stores')->delete();

        $waytocakeUser = User::firstOrCreate(
            ['email' => 'waytocake@gmail.com'],
            [
                'name'              => 'WayToCake Seller',
                'password'          => Hash::make('password123'),
                'role'              => 'seller',
                'email_verified_at' => now(),
            ]
        );

        Store::create([
            'user_id'     => $waytocakeUser->id,
            'name'        => 'wayToCake',
            'logo'        => 'wtc-logo.png',
            'about'       => 'Toko khusus aksesori Y2K',
            'phone'       => '08987654321',
            'address_id'  => 2221,
            'city'        => 'Malang',
            'address'     => 'Jl. Siragu-ragu No. 22',
            'postal_code' => '65100',
            'is_verified' => false,
        ]);

        $sellerUser = User::firstOrCreate(
            ['email' => 'seller@gmail.com'],
            [
                'name'              => 'Seller',
                'password'          => Hash::make('password123'),
                'role'              => 'seller',
                'email_verified_at' => now(),
            ]
        );

        Store::create([
            'user_id'     => $sellerUser->id,
            'name'        => 'Toko Seller',
            'about'       => 'Ini adalah toko contoh untuk user seller.',
            'phone'       => '08123456789',
            'address'     => 'Jl. Contoh No.123',
            'city'        => 'Kota Mayong',
            'postal_code' => '12345',
            'is_verified' => true,
            'logo'        => 'default',
            'address_id'  => 0,
        ]);
    }
}
