<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\ProductReview;
use App\Models\Store;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Buyer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class WomensTopsSeeder extends Seeder
{
    public function run()
    {
        // 1. Ensure "Women" Category exists and create sub-categories
        $womenCategory = ProductCategory::where('slug', 'women')->first();
        
        if (!$womenCategory) {
            $womenCategory = ProductCategory::create([
                'name' => 'Women',
                'slug' => 'women',
                'description' => 'Women\'s Fashion Collection'
            ]);
        }

        $subcategories = ['Shirts', 'Pants', 'Jackets', 'Shoes', 'Accessories'];
        $targetCategory = null;

        foreach ($subcategories as $sub) {
            $slug = 'women-' . Str::slug($sub);
            $cat = ProductCategory::firstOrCreate(
                ['name' => $sub, 'parent_id' => $womenCategory->id],
                [
                    'slug' => $slug,
                    'description' => "Women's $sub Collection"
                ]
            );

            if ($sub === 'Shirts') {
                $targetCategory = $cat; // Use Shirts for our products
            }
        }
        
        $category = $targetCategory;

        // 2. Ensure Store exists
        $user = User::firstOrCreate(
            ['email' => 'store@example.com'],
            [
                'name' => 'Fashion Store Owner',
                'password' => Hash::make('password'),
                'role' => 'member',
            ]
        );

        $store = Store::firstOrCreate(
            ['user_id' => $user->id],
            [
                'name' => 'Fashionista Official',
                'slug' => 'fashionista-official',
                'about' => 'Your daily dose of style.',
                'phone' => '081122334455',
                'city' => 'Jakarta',
                'postal_code' => '12345',
                'address' => 'Jakarta Fashion District',
                'is_verified' => true
            ]
        );

        // 3. Create Products
        $products = [
            [
                'name' => 'Cream Cable Knit Cardigan',
                'description' => 'Experience the ultimate comfort with our Cream Cable Knit Cardigan. Features intricate knitting details, premium wool blend fabric, and elegant buttons. Perfect for chilly evenings or office wear.',
                'image' => 'products/top1.jpg',
                'price' => 450000,
            ],
            [
                'name' => 'Black Tweed Jacket',
                'description' => 'Sophisticated Black Tweed Jacket designed for the modern woman. Accented with vintage gold buttons and structured shoulders. Ideal for formal events or elevating a casual jeans look.',
                'image' => 'products/top2.jpg',
                'price' => 899000,
            ],
            [
                'name' => 'Classic Striped Oxford Shirt',
                'description' => 'A wardrobe essential, this Classic Striped Oxford Shirt offers a crisp, tailored fit. Made from breathable cotton, it ensures all-day comfort while looking professionally sharp.',
                'image' => 'products/top3.jpg',
                'price' => 350000,
            ],
            [
                'name' => 'Blue & White Oversized Shirt',
                'description' => 'Embrace the relaxed vibe with our Blue & White Oversized Shirt. Features drops shoulders and a breezy fit. Pairs perfectly with leggings or tucked into high-waisted trousers.',
                'image' => 'products/top4.jpg',
                'price' => 299000,
            ],
            [
                'name' => 'Pink Pinstripe Blouse',
                'description' => 'Add a touch of femininity to your workwear with this Pink Pinstripe Blouse. Designed with a flattering waist cut and subtle stripe pattern. Soft, lightweight, and stylish.',
                'image' => 'products/top5.jpg',
                'price' => 320000,
            ],
        ];

        // 4. Create Buyer for Reviews
        $buyerUser = User::firstOrCreate(
            ['email' => 'reviewer@example.com'],
            [
                'name' => 'Jessica Style',
                'password' => Hash::make('password'),
                'role' => 'member',
            ]
        );
        $buyer = Buyer::firstOrCreate(['user_id' => $buyerUser->id]);

        foreach ($products as $item) {
            $product = Product::firstOrCreate(
                [
                    'name' => $item['name'],
                    'store_id' => $store->id,
                ],
                [
                    'product_category_id' => $category->id,
                    'slug' => Str::slug($item['name']) . '-' . Str::random(5),
                    'description' => $item['description'],
                    'condition' => 'new',
                    'price' => $item['price'],
                    'weight' => rand(200, 500),
                    'stock' => rand(10, 50),
                ]
            );

            // Add Image if not exists
            if (!$product->productImages()->exists()) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $item['image'],
                ]);
            }

            // Only create dummy transaction and reviews if product was recently created to avoid duplicates
            if ($product->wasRecentlyCreated) {
                // Create a Mock Transaction for Review
                $transaction = Transaction::create([
                    'code' => 'TRX-' . Str::random(10),
                    'buyer_id' => $buyer->id,
                    'store_id' => $store->id,
                    'address' => 'Test Address',
                    'address_id' => '1',
                    'city' => 'Jakarta',
                    'postal_code' => '12345',
                    'shipping' => 'JNE',
                    'shipping_type' => 'REG',
                    'payment_status' => 'paid',
                    'grand_total' => $item['price'],
                    'shipping_cost' => 0,
                    'tax' => 0,
                ]);

                // Create Transaction Detail (Required for review verification)
                \App\Models\TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'qty' => 1,
                    'subtotal' => $item['price'],
                ]);

                // Create Reviews (3-5 random reviews)
                $reviewCount = rand(3, 5);
                $reviews = [
                    'Absolutely love this!',
                    'Great quality material, fits perfectly.',
                    'Good value for money.',
                    'Delivery was fast and item as described.',
                    'Highly recommended!',
                    'Looks exactly like the photo.'
                ];

                for ($i = 0; $i < $reviewCount; $i++) {
                    ProductReview::create([
                        'transaction_id' => $transaction->id,
                        'product_id' => $product->id,
                        'rating' => rand(4, 5),
                        'review' => $reviews[array_rand($reviews)],
                        'created_at' => now()->subDays(rand(1, 30)),
                    ]);
                }
            }
        }
    }
}
