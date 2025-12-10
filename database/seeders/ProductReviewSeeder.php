<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\ProductReview;

class ProductReviewSeeder extends Seeder
{
    public function run()
    {
        $products = Product::all();
        $transactions = Transaction::all();

        if ($products->isEmpty() || $transactions->isEmpty()) {
            $this->command->info('Tidak ada produk atau transaksi, seeding dibatalkan.');
            return;
        }

        foreach ($products as $product) {
            // Jumlah review per produk (1-5)
            $reviewCount = rand(1, 5);

            for ($i = 0; $i < $reviewCount; $i++) {
                ProductReview::create([
                    'product_id' => $product->id,
                    'transaction_id' => $transactions->random()->id, // ambil transaksi random
                    'rating' => rand(1, 5),
                    'review' => fake()->sentence(10),
                ]);
            }
        }
    }
}
