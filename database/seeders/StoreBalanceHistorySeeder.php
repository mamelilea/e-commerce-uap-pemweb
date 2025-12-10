<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StoreBalance;
use App\Models\StoreBalanceHistory;

class StoreBalanceHistorySeeder extends Seeder
{
    public function run()
    {
        $storeBalances = StoreBalance::all();

        if ($storeBalances->isEmpty()) {
            $this->command->info('Tidak ada store balance, seeding dibatalkan.');
            return;
        }

        foreach ($storeBalances as $balance) {
            // Buat 3-5 history untuk tiap store balance
            $historyCount = rand(3, 5);

            for ($i = 0; $i < $historyCount; $i++) {
                StoreBalanceHistory::create([
                    'store_balance_id' => $balance->id,
                    'type' => fake()->randomElement(['credit', 'debit']), // kredit atau debit
                    'reference_id' => null, // bisa diisi sesuai transaksi terkait
                    'reference_type' => null,
                    'amount' => fake()->randomFloat(2, 10, 1000),
                    'remarks' => fake()->sentence(6),
                ]);
            }
        }
    }
}
