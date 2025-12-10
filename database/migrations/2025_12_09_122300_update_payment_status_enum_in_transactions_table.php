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
        // Using raw SQL because altering enums can be tricky with Eloquent
        DB::statement("ALTER TABLE transactions MODIFY COLUMN payment_status ENUM('unpaid', 'paid', 'processed', 'shipped', 'completed', 'cancelled') DEFAULT 'unpaid'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE transactions MODIFY COLUMN payment_status ENUM('unpaid', 'paid') DEFAULT 'unpaid'");
    }
};
