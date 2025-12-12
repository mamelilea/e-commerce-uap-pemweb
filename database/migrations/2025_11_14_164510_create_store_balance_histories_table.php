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
        Schema::create('store_balance_histories', function (Blueprint $table) {
            $table->id()->primary();
            $table->foreignId('store_balance_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['income', 'withdraw', 'credit', 'debit']);
            $table->string('reference_id')->nullable();
            $table->string('reference_type')->nullable();
            $table->decimal('amount', 26, 2);
            $table->string('description'); // Renamed from remarks to match usage
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_balance_histories');
    }
};
