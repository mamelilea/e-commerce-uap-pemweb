<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductReview;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;

class ProductReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Korean idol names
        $idolNames = [
            'Kim Jisoo', 'Jennie Kim', 'Park Chaeyoung', 'Lalisa Manoban',
            'Kim Taehyung', 'Park Jimin', 'Jeon Jungkook', 'Kim Namjoon',
            'Min Yoongi', 'Jung Hoseok', 'Kim Seokjin',
            'Kang Seulgi', 'Bae Joohyun', 'Park Sooyoung', 'Kim Yerim',
            'Hwang Yeji', 'Choi Jisu', 'Shin Ryujin', 'Lee Chaeryeong',
            'Kim Minjeong', 'Yoo Jimin', 'Ning Yizhuo', 'Uchinaga Aeri',
            'Choi Yeonjun', 'Choi Soobin', 'Choi Beomgyu', 'Kang Taehyun',
            'Lee Heeseung', 'Park Jongseong', 'Sim Jaeyun', 'Park Sunghoon',
        ];

        // Review templates
        $reviewTemplates = [
            'Amazing quality! The product exceeded my expectations. Highly recommended! 💖',
            'Love this so much! Packaging was perfect and delivery was fast. Will buy again!',
            'This is exactly what I wanted! The quality is top-notch. Thank you! ✨',
            'Super happy with my purchase! The item is even better in person. 5 stars!',
            'Great product! Worth every penny. The seller was very responsive too.',
            'Absolutely love it! The quality is excellent and shipping was quick.',
            'Perfect! Just as described. I\'m so satisfied with this purchase! 🌟',
            'Highly recommend! The product quality is amazing. Will definitely order more!',
            'Best purchase ever! Everything about this is perfect. Thank you so much!',
            'So happy with this! The quality exceeded my expectations. Love it! 💕',
            'Incredible quality! Fast shipping and great packaging. Very satisfied!',
            'This is perfect! Exactly what I was looking for. Highly recommended!',
            'Love love love! The quality is outstanding. Will be a repeat customer!',
            'Amazing! The product is beautiful and well-made. Thank you! ⭐',
            'Very satisfied! Great quality and fast delivery. Couldn\'t be happier!',
        ];

        // Get all products
        $products = Product::all();

        $userCounter = 0;

        foreach ($products as $product) {
            // Random number of reviews per product (2-5 reviews)
            $reviewCount = rand(2, 5);

            for ($i = 0; $i < $reviewCount; $i++) {
                // Create or get a user with idol name
                $idolName = $idolNames[$userCounter % count($idolNames)];
                $email = strtolower(str_replace(' ', '.', $idolName)) . '@kpop.fan';
                
                $user = User::firstOrCreate(
                    ['email' => $email],
                    [
                        'name' => $idolName,
                        'password' => bcrypt('password'),
                        'role' => 'member',
                    ]
                );
                
                // Ensure buyer record exists
                $buyer = \App\Models\Buyer::firstOrCreate(['user_id' => $user->id]);

                // Create a transaction for this review
                $transaction = Transaction::create([
                    'code' => 'TRX-' . time() . '-' . strtoupper(substr(md5(uniqid()), 0, 6)),
                    'user_id' => $user->id,
                    'buyer_id' => $buyer->id,
                    'store_id' => $product->store_id,
                    'payment_method' => 'wallet',
                    'shipping_type' => 'regular',
                    'address' => 'Seoul, South Korea',
                    'grand_total' => $product->price,
                    'payment_status' => 'paid',
                    'shipping_cost' => 15000,
                ]);

                // Create review with random rating (4-5 stars for positive reviews)
                ProductReview::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'rating' => rand(4, 5),
                    'review' => $reviewTemplates[array_rand($reviewTemplates)],
                ]);

                $userCounter++;
            }
        }

        $this->command->info('Product reviews seeded successfully with K-Pop idol names!');
    }
}
