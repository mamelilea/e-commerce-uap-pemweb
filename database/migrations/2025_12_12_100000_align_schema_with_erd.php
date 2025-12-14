<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Create Buyers Table (if not exists)
        if (!Schema::hasTable('buyers')) {
            Schema::create('buyers', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->string('profile_picture')->nullable();
                $table->string('phone_number')->nullable();
                $table->timestamps();
            });

            // Migrate data from users to buyers (if applicable)
            $users = DB::table('users')->where('role', 'member')->get();
            foreach ($users as $user) {
                // Check if already exists to avoid duplicates
                $exists = DB::table('buyers')->where('user_id', $user->id)->exists();
                if (!$exists) {
                    DB::table('buyers')->insert([
                        'user_id' => $user->id,
                        'profile_picture' => $user->avatar ?? null, 
                        'phone_number' => $user->phone ?? null,     
                        'created_at' => $user->created_at,
                        'updated_at' => $user->updated_at,
                    ]);
                }
            }
        }

        // 2. Create Store Balances Table (if not exists)
        if (!Schema::hasTable('store_balances')) {
            Schema::create('store_balances', function (Blueprint $table) {
                $table->id();
                $table->foreignId('store_id')->constrained('stores')->cascadeOnDelete();
                $table->decimal('balance', 12, 2)->default(0);
                $table->timestamps();
            });

            // Migrate balance from stores to store_balances
            if (Schema::hasColumn('stores', 'balance')) {
                $stores = DB::table('stores')->get();
                foreach ($stores as $store) {
                   $exists = DB::table('store_balances')->where('store_id', $store->id)->exists();
                   if (!$exists) {
                        DB::table('store_balances')->insert([
                            'store_id' => $store->id,
                            'balance' => $store->balance,
                            'created_at' => $store->created_at,
                            'updated_at' => $store->updated_at,
                        ]);
                   }
                }
            }
        }

        // 3. Modify Products Table
        Schema::table('products', function (Blueprint $table) {
            // Rename description to about
            if (Schema::hasColumn('products', 'description') && !Schema::hasColumn('products', 'about')) {
                 $table->renameColumn('description', 'about');
            }
        });

        // 4. Modify Transactions Table
        Schema::table('transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('transactions', 'buyer_id')) {
                $table->foreignId('buyer_id')->nullable()->constrained('buyers')->cascadeOnDelete()->after('code');
            }
            if (!Schema::hasColumn('transactions', 'address_id')) {
                $table->foreignId('address_id')->nullable()->after('store_id'); 
            }
            if (!Schema::hasColumn('transactions', 'city')) {
                $table->string('city')->nullable()->after('address');
            }
            if (!Schema::hasColumn('transactions', 'postal_code')) {
                $table->string('postal_code')->nullable()->after('city');
            }
            if (!Schema::hasColumn('transactions', 'shipping')) {
                $table->string('shipping')->nullable()->after('postal_code'); // Provider name e.g. JNE
            }
            if (!Schema::hasColumn('transactions', 'shipping_type')) {
                 $table->string('shipping_type')->nullable()->after('shipping');
            }
             if (!Schema::hasColumn('transactions', 'shipping_cost')) {
                $table->decimal('shipping_cost', 12, 2)->default(0)->after('shipping_type');
            }
            if (!Schema::hasColumn('transactions', 'tracking_number')) {
                 $table->string('tracking_number')->nullable()->after('shipping_cost');
            }
            if (!Schema::hasColumn('transactions', 'tax')) {
                $table->decimal('tax', 12, 2)->default(0)->after('tracking_number');
            }
            if (!Schema::hasColumn('transactions', 'grand_total') && Schema::hasColumn('transactions', 'total_amount')) {
                $table->renameColumn('total_amount', 'grand_total');
            }
        });
        
        // Populate buyer_id in transactions
        if (Schema::hasColumn('transactions', 'user_id')) {
            $transactions = DB::table('transactions')->whereNull('buyer_id')->get();
            foreach ($transactions as $t) {
                // Assuming transactions have user_id which maps to a buyer
                $buyer = DB::table('buyers')->where('user_id', $t->user_id)->first();
                if ($buyer) {
                    DB::table('transactions')->where('id', $t->id)->update(['buyer_id' => $buyer->id]);
                }
            }
        }

        // 5. Cleanup Stores Table (Drop balance if migrated)
        Schema::table('stores', function (Blueprint $table) {
            if (Schema::hasColumn('stores', 'balance')) {
                $table->dropColumn('balance');
            }
        });

        // 6. Fix Store Balance Histories (Constraint Change)
        Schema::table('store_balance_histories', function (Blueprint $table) {
             // Step 1: Add new column
            if (!Schema::hasColumn('store_balance_histories', 'store_balance_id')) {
                 $table->foreignId('store_balance_id')->nullable()->after('id')->constrained('store_balances')->cascadeOnDelete();
            }
        });

        // Migrate data for store_balance_histories
        if (Schema::hasColumn('store_balance_histories', 'store_id') && Schema::hasColumn('store_balance_histories', 'store_balance_id')) {
            $histories = DB::table('store_balance_histories')->whereNull('store_balance_id')->get();
            foreach ($histories as $h) {
                $balance = DB::table('store_balances')->where('store_id', $h->store_id)->first();
                if ($balance) {
                    DB::table('store_balance_histories')->where('id', $h->id)->update(['store_balance_id' => $balance->id]);
                }
            }
            
            // Now drop store_id
             Schema::table('store_balance_histories', function (Blueprint $table) {
                 if (Schema::hasColumn('store_balance_histories', 'store_id')) {
                     // Drop foreign key first. 
                     $table->dropForeign(['store_id']); 
                     $table->dropColumn('store_id');
                 }
             });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reversal logic
        
        Schema::table('store_balance_histories', function (Blueprint $table) {
            if (!Schema::hasColumn('store_balance_histories', 'store_id')) {
                 $table->foreignId('store_id')->nullable()->constrained('stores');
            }
             if (Schema::hasColumn('store_balance_histories', 'store_balance_id')) {
                $table->dropForeign(['store_balance_id']);
                $table->dropColumn('store_balance_id');
             }
        });

        Schema::table('stores', function (Blueprint $table) {
            if (!Schema::hasColumn('stores', 'balance')) {
                $table->decimal('balance', 12, 2)->default(0);
            }
        });
        
        Schema::table('transactions', function (Blueprint $table) {
            if (Schema::hasColumn('transactions', 'grand_total')) {
                $table->renameColumn('grand_total', 'total_amount');
            }
            $table->dropColumn(['buyer_id', 'address_id', 'city', 'postal_code', 'shipping', 'tax']);
        });

        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'about')) {
                $table->renameColumn('about', 'description');
            }
        });

        Schema::dropIfExists('store_balances');
        Schema::dropIfExists('buyers');
    }
};
