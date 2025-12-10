<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\Buyer;
use App\Models\Store;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        $buyers = Buyer::all();
        $stores = Store::all();

        if ($buyers->isEmpty() || $stores->isEmpty()) {
            $this->command->info('Tidak ada buyer atau store, seeding transaksi dibatalkan.');
            return;
        }

        foreach ($buyers as $buyer) {
            // Jumlah transaksi per buyer (1-5)
            $transactionCount = rand(1, 5);

            for ($i = 0; $i < $transactionCount; $i++) {
                $store = $stores->random();

                $shippingCost = fake()->randomFloat(2, 5, 50);
                $tax = fake()->randomFloat(2, 1, 20);
                $grandTotal = fake()->randomFloat(2, 50, 500);

                Transaction::create([
                    'code' => strtoupper(fake()->unique()->bothify('TRX-#####')),
                    'buyer_id' => $buyer->id,
                    'store_id' => $store->id,
                    'address' => fake()->address(),
                    'address_id' => null,
                    'city' => fake()->city(),
                    'postal_code' => fake()->postcode(),
                    'shipping' => 'delivery',
                    'shipping_type' => fake()->randomElement(['jne', 'tiki', 'pos']),
                    'shipping_cost' => $shippingCost,
                    'tracking_number' => fake()->bothify('TRK-########'),
                    'tax' => $tax,
                    'grand_total' => $grandTotal + $shippingCost + $tax,
                    'payment_status' => fake()->randomElement(['pending', 'paid', 'failed']),
                    'status' => fake()->randomElement(['pending', 'processing', 'shipped', 'completed']),
                ]);
            }
        }
    }
}
