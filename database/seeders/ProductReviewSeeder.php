<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductReview;

class ProductReviewSeeder extends Seeder
{
    public function run(): void
    {
        ProductReview::insert([
            // Review untuk Produk 1
            [
                'transaction_id' => 1,
                'product_id'     => 1,
                'rating'         => 5,
                'review'         => 'Samsung Galaxy S23 Ultra luar biasa, kamera sangat tajam!',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'transaction_id' => 2,
                'product_id'     => 1,
                'rating'         => 4,
                'review'         => 'Performa cepat tapi baterai cepat habis.',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],

            // Review untuk Produk 2
            [
                'transaction_id' => 3,
                'product_id'     => 2,
                'rating'         => 5,
                'review'         => 'MacBook Air M2 ringan dan cepat, sangat puas.',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],

            // Review untuk Produk 3
            [
                'transaction_id' => 4,
                'product_id'     => 3,
                'rating'         => 4,
                'review'         => 'Sony WH-1000XM5 nyaman, tapi agak mahal.',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],

            // Review untuk Produk 4
            [
                'transaction_id' => 5,
                'product_id'     => 4,
                'rating'         => 5,
                'review'         => 'Charger cepat Baseus sangat membantu, kompatibel semua device.',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);
    }
}
