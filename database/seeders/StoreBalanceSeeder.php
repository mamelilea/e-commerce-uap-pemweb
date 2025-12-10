<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Store;
use App\Models\StoreBalance;

class StoreBalanceSeeder extends Seeder
{
    public function run()
    {
        $stores = Store::all();

        if ($stores->isEmpty()) {
            $this->command->info('Tidak ada store, seeding StoreBalance dibatalkan.');
            return;
        }

        foreach ($stores as $store) {
            // Buat balance awal untuk tiap store
            StoreBalance::create([
                'store_id' => $store->id,
                'balance' => fake()->randomFloat(2, 100, 10000), // saldo antara 100 - 10.000
            ]);
        }
    }
}
