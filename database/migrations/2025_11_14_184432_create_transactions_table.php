<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('code')->unique();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('store_id')->constrained('stores')->cascadeOnDelete();
            $table->text('address')->nullable();
            $table->string('shipping_type')->nullable();
            $table->decimal('shipping_cost', 12, 2)->default(0);
            $table->string('tracking_number')->nullable();
            $table->decimal('total_amount', 12, 2);
            $table->enum('payment_method', ['wallet', 'va']);
            $table->enum('payment_status', ['unpaid', 'paid', 'cancelled'])->default('unpaid');
            $table->string('va_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
