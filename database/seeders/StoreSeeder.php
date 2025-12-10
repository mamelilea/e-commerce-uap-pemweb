<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Store;
use App\Models\User;

class StoreSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->info('Tidak ada user, seeding store dibatalkan.');
            return;
        }

        foreach ($users as $user) {
            Store::create([
                'user_id' => $user->id,
                'name' => fake()->company(),
                'logo' => 'default-logo.png',
                'about' => fake()->paragraph(),
                'phone' => fake()->phoneNumber(),
                'address_id' => null, // sesuaikan jika ada tabel alamat
                'city' => fake()->city(),
                'address' => fake()->address(),
                'postal_code' => fake()->postcode(),
                'is_verified' => fake()->boolean(70), // 70% kemungkinan terverifikasi
            ]);
        }
    }
}
