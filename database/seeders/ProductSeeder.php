<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Store;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductReview;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Buyer;
use App\Models\StoreBalance;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample users for store owners
        $storeOwner1 = User::create([
            'name' => 'John Doe',
            'email' => 'store1@example.com',
            'password' => bcrypt('password'),
            'role' => 'member',
        ]);

        $storeOwner2 = User::create([
            'name' => 'Jane Smith',
            'email' => 'store2@example.com',
            'password' => bcrypt('password'),
            'role' => 'member',
        ]);

        // Create sample stores
        $store1 = Store::create([
            'user_id' => $storeOwner1->id,
            'name' => 'XIV Collective',
            'slug' => 'xiv-collective',
            'logo' => 'stores/logo-1.png',
            'about' => 'Premium fashion brand focusing on contemporary streetwear and minimalist design.',
            'phone' => '08123456789',
            'address_id' => 1,
            'address' => 'Jl. Sudirman No. 123',
            'city' => 'Jakarta',
            'postal_code' => '12190',
            'is_verified' => true,
        ]);

        $store2 = Store::create([
            'user_id' => $storeOwner2->id,
            'name' => 'Urban Style',
            'slug' => 'urban-style',
            'logo' => 'stores/logo-2.png',
            'about' => 'Modern fashion for the contemporary individual.',
            'phone' => '08198765432',
            'address_id' => 2,
            'address' => 'Jl. Gatot Subroto No. 456',
            'city' => 'Bandung',
            'postal_code' => '40123',
            'is_verified' => true,
        ]);

        // Create store balances
        StoreBalance::create(['store_id' => $store1->id, 'balance' => 0]);
        StoreBalance::create(['store_id' => $store2->id, 'balance' => 0]);

        // Create product categories
        $parentCategories = [
            ['name' => 'Men', 'slug' => 'men', 'tagline' => 'Fashion for Him', 'description' => 'Latest trends for men'],
            ['name' => 'Women', 'slug' => 'women', 'tagline' => 'Fashion for Her', 'description' => 'Latest trends for women'],
            ['name' => 'Kids', 'slug' => 'kids', 'tagline' => 'Fashion for Kids', 'description' => 'Comfortable wear for kids'],
        ];

        $categoryModels = [];
        
        foreach ($parentCategories as $parent) {
            $parentModel = ProductCategory::create($parent);
            $categoryModels[$parent['slug']] = $parentModel;

            // Subcategories
            $subcategories = [];
            if ($parent['slug'] === 'men') {
                $subcategories = ['T-Shirts', 'Shirts', 'Pants', 'Jeans', 'Shorts', 'Suits', 'Outerwear', 'Sportswear', 'Shoes', 'Accessories', 'Bags'];
            } elseif ($parent['slug'] === 'women') {
                $subcategories = ['Tops', 'Blouses', 'Dresses', 'Jumpsuits', 'Pants', 'Jeans', 'Skirts', 'Outerwear', 'Sportswear', 'Shoes', 'Accessories', 'Bags', 'Hijab'];
            } elseif ($parent['slug'] === 'kids') {
                $subcategories = ['Boys Clothing', 'Girls Clothing', 'Baby Clothing', 'School Uniforms', 'Shoes', 'Toys', 'Accessories'];
            }

            foreach ($subcategories as $sub) {
                $subModel = ProductCategory::create([
                    'name' => $sub,
                    'slug' => $parent['slug'] . '-' . Str::slug($sub),
                    'parent_id' => $parentModel->id,
                    'tagline' => $sub . ' for ' . $parent['name'],
                    'description' => 'Best ' . $sub . ' collection',
                ]);
                $categoryModels[$parent['slug'] . '-' . Str::slug($sub)] = $subModel;
            }
        }

        // Sample product data
        $products = [
            // Men
            ['name' => 'Oversize Tee - White', 'category' => 'men-t-shirts', 'store' => $store1, 'price' => 199000, 'description' => 'Premium oversized t-shirt in pure white.'],
            ['name' => 'Slim Fit Chino - Navy', 'category' => 'men-pants', 'store' => $store1, 'price' => 299000, 'description' => 'Classic navy chinos for smart casual look.'],
            ['name' => 'Denim Jacket - Vintage', 'category' => 'men-outerwear', 'store' => $store2, 'price' => 450000, 'description' => 'Vintage wash denim jacket.'],
            ['name' => 'Oxford Shirt - Blue', 'category' => 'men-shirts', 'store' => $store2, 'price' => 349000, 'description' => 'Classic blue oxford shirt.'],
            ['name' => 'Canvas Sneakers - Black', 'category' => 'men-shoes', 'store' => $store1, 'price' => 399000, 'description' => 'Versatile black canvas sneakers.'],
            ['name' => 'Slim Fit Suit - Black', 'category' => 'men-suits', 'store' => $store2, 'price' => 1299000, 'description' => 'Elegant black suit for formal occasions.'],
            ['name' => 'Cargo Shorts - Khaki', 'category' => 'men-shorts', 'store' => $store1, 'price' => 249000, 'description' => 'Functional cargo shorts with multiple pockets.'],
            ['name' => 'Running Jacket - Neon', 'category' => 'men-sportswear', 'store' => $store2, 'price' => 399000, 'description' => 'Lightweight running jacket for night runs.'],
            ['name' => 'Leather Messenger Bag', 'category' => 'men-bags', 'store' => $store1, 'price' => 899000, 'description' => 'Genuine leather messenger bag.'],
            
            // Women
            ['name' => 'Floral Summer Dress', 'category' => 'women-dresses', 'store' => $store1, 'price' => 259000, 'description' => 'Light and airy floral dress.'],
            ['name' => 'High Waist Jeans', 'category' => 'women-jeans', 'store' => $store2, 'price' => 329000, 'description' => 'Flattering high waist jeans.'],
            ['name' => 'Crop Top - Lavender', 'category' => 'women-tops', 'store' => $store1, 'price' => 129000, 'description' => 'Cute lavender crop top.'],
            ['name' => 'Pleated Skirt - Beige', 'category' => 'women-skirts', 'store' => $store2, 'price' => 219000, 'description' => 'Elegant beige pleated skirt.'],
            ['name' => 'Running Shoes - Pink', 'category' => 'women-shoes', 'store' => $store1, 'price' => 599000, 'description' => 'Comfortable pink running shoes.'],
            ['name' => 'Silk Blouse - Emerald', 'category' => 'women-blouses', 'store' => $store2, 'price' => 459000, 'description' => 'Luxurious silk blouse in emerald green.'],
            ['name' => 'Jumpsuit - Navy', 'category' => 'women-jumpsuits', 'store' => $store1, 'price' => 399000, 'description' => 'Chic navy jumpsuit for evening wear.'],
            ['name' => 'Pashmina Instant', 'category' => 'women-hijab', 'store' => $store2, 'price' => 89000, 'description' => 'Easy to wear instant pashmina.'],
            ['name' => 'Tote Bag - Canvas', 'category' => 'women-bags', 'store' => $store1, 'price' => 159000, 'description' => 'Durable canvas tote bag.'],

            // Kids
            ['name' => 'Dinosaur Tee', 'category' => 'kids-boys-clothing', 'store' => $store2, 'price' => 99000, 'description' => 'Fun dinosaur print t-shirt.'],
            ['name' => 'Princess Dress', 'category' => 'kids-girls-clothing', 'store' => $store1, 'price' => 149000, 'description' => 'Beautiful princess dress for parties.'],
            ['name' => 'Kids Sneakers - Velcro', 'category' => 'kids-shoes', 'store' => $store2, 'price' => 199000, 'description' => 'Easy to wear velcro sneakers.'],
            ['name' => 'School Uniform Set', 'category' => 'kids-school-uniforms', 'store' => $store1, 'price' => 299000, 'description' => 'Complete school uniform set.'],
            ['name' => 'Baby Onesie - Cotton', 'category' => 'kids-baby-clothing', 'store' => $store2, 'price' => 79000, 'description' => 'Soft cotton onesie for babies.'],
        ];

        foreach ($products as $index => $productData) {
            $product = Product::create([
                'store_id' => $productData['store']->id,
                'product_category_id' => $categoryModels[$productData['category']]->id,
                'name' => $productData['name'],
                'slug' => Str::slug($productData['name']) . '-' . Str::random(4),
                'description' => $productData['description'],
                'condition' => 'new',
                'price' => $productData['price'],
                'weight' => rand(200, 500),
                'stock' => rand(10, 50),
            ]);

            // Note: In production, you would upload actual images
            // For now, we'll just create placeholder entries
            ProductImage::create([
                'product_id' => $product->id,
                'image' => 'products/placeholder-' . (($index % 5) + 1) . '.jpg', // Cycle through 5 placeholders
                'is_thumbnail' => true,
            ]);
        }

        // Create a sample buyer and reviews
        $buyer = User::create([
            'name' => 'Customer Sample',
            'email' => 'customer@example.com',
            'password' => bcrypt('password'),
            'role' => 'member',
        ]);

        $buyerProfile = Buyer::create([
            'user_id' => $buyer->id,
            'phone_number' => '081234567890',
        ]);

        // Create sample reviews for some products
        $reviewedProducts = Product::take(5)->get();
        foreach ($reviewedProducts as $product) {
            // Create a sample transaction first
            $transaction = Transaction::create([
                'code' => 'TRX-' . strtoupper(Str::random(10)),
                'buyer_id' => $buyerProfile->id,
                'store_id' => $product->store_id,
                'address_id' => 1,
                'address' => 'Jl. Sample No. 123',
                'city' => 'Jakarta',
                'postal_code' => '12345',
                'shipping' => 'JNE',
                'shipping_type' => 'regular',
                'shipping_cost' => 10000,
                'tax' => $product->price * 0.11,
                'grand_total' => $product->price + 10000 + ($product->price * 0.11),
                'payment_status' => 'paid',
            ]);

            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $product->id,
                'qty' => 1,
                'subtotal' => $product->price,
            ]);

            ProductReview::create([
                'transaction_id' => $transaction->id,
                'product_id' => $product->id,
                'rating' => rand(4, 5),
                'review' => 'Great product! Very satisfied with the quality and fit.',
            ]);
        }

        $this->command->info('Sample products, categories, stores, and reviews created successfully!');
    }
}
