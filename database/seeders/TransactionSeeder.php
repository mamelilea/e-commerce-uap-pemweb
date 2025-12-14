<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;
use App\Models\User;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        // Get a buyer user (member role)
        $buyer = User::where('role', 'member')->first();
        
        if (!$buyer) {
            $buyer = User::create([
                'name' => 'Customer Test',
                'email' => 'customer@test.com',
                'password' => bcrypt('password'),
                'role' => 'member',
            ]);
        }

        // Get ALL stores
        $stores = \App\Models\Store::all();

        if ($stores->isEmpty()) {
            $this->command->info('No stores found. Please create a store first.');
            return;
        }

        foreach ($stores as $store) {
            $this->command->info("Processing store: {$store->name}");

            // Get products from THIS store
            $products = Product::where('store_id', $store->id)->take(5)->get();

            if ($products->isEmpty()) {
                $this->command->info("No products found for store {$store->name}. Creating dummy products...");
                
                // Get a category or create one
                $category = \App\Models\ProductCategory::first();
                if (!$category) {
                    $category = \App\Models\ProductCategory::create([
                        'name' => 'General',
                        'slug' => 'general'
                    ]);
                }

                // Create 3 dummy products
                for ($j = 1; $j <= 3; $j++) {
                    Product::create([
                        'store_id' => $store->id,
                        'product_category_id' => $category->id,
                        'name' => "Dummy Product $j for " . $store->name,
                        'slug' => \Illuminate\Support\Str::slug("Dummy Product $j " . uniqid()),
                        'about' => 'This is a dummy product for testing.',
                        'price' => rand(50000, 500000),
                        'stock' => 100,
                        'condition' => 'new',
                        'weight' => 500, // 500 grams
                    ]);
                }
                
                $products = Product::where('store_id', $store->id)->get();
            }

            // Ensure store balance record exists
            $storeBalance = \App\Models\StoreBalance::firstOrCreate(
                ['store_id' => $store->id],
                ['balance' => 0]
            );

            // Create 3 dummy transactions for EACH store
            for ($i = 1; $i <= 3; $i++) {
                $product = $products->random();
                $quantity = rand(1, 3);
                $subtotal = $product->price * $quantity;
                $shippingCost = rand(10000, 50000);
                $grandTotal = $subtotal + $shippingCost;
                
                $paymentStatus = ['unpaid', 'paid', 'paid'][rand(0, 2)];

                // Create transaction
                $transaction = Transaction::create([
                    'code' => 'SMX-' . date('Ymd') . '-' . rand(1000, 9999) . '-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                    'user_id' => $buyer->id,
                    'store_id' => $store->id,
                    'address' => 'Jl. Test No. ' . rand(1, 100) . ', Jakarta Selatan',
                    'city' => 'Jakarta Selatan',
                    'postal_code' => '12' . rand(100, 999),
                    'shipping' => $shippingCost,
                    'shipping_cost' => $shippingCost,
                    'tax' => 0,
                    'grand_total' => $grandTotal,
                    'payment_method' => ['wallet', 'va'][rand(0, 1)],
                    'payment_status' => $paymentStatus,
                    'shipping_info' => rand(0, 1) ? 'JNE REG - Resi: JNE' . rand(100000000, 999999999) : null,
                    'tracking_number' => rand(0, 1) ? 'JNE' . rand(100000000, 999999999) : null,
                ]);

                // Create transaction detail
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'qty' => $quantity,
                    'subtotal' => $subtotal,
                ]);

                // If paid, update store balance and create history
                if ($paymentStatus === 'paid') {
                    // Update balance (exclude shipping cost usually, but let's include subtotal only for revenue)
                    $revenue = $subtotal; 
                    
                    $storeBalance->balance += $revenue;
                    $storeBalance->save();

                    // Create history
                    \App\Models\StoreBalanceHistory::create([
                        'store_balance_id' => $storeBalance->id,
                        'type' => 'income', // enum: income, withdraw
                        'reference_id' => $transaction->id,
                        'reference_type' => 'transaction',
                        'amount' => $revenue,
                        'remarks' => 'Sales revenue from ' . $transaction->code,
                    ]);
                }

                $this->command->info("Created transaction #{$transaction->code} for store {$store->name}");
            }
        }

        $this->command->info('Transaction seeder completed successfully!');
    }
}
