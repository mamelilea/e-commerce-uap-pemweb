<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\TransactionDetail;

class TransactionDetailSeeder extends Seeder
{
    public function run()
    {
        $transactions = Transaction::all();
        $products = Product::all();

        if ($transactions->isEmpty() || $products->isEmpty()) {
            $this->command->info('Tidak ada transaksi atau produk, seeding dibatalkan.');
            return;
        }

        foreach ($transactions as $transaction) {
            // Jumlah produk per transaksi (1-5)
            $detailCount = rand(1, 5);

            $selectedProducts = $products->random($detailCount);

            foreach ($selectedProducts as $product) {
                $qty = rand(1, 3);
                $subtotal = $product->price * $qty;

                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'qty' => $qty,
                    'subtotal' => $subtotal,
                ]);
            }
        }
    }
}
