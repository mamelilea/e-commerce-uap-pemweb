<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // 1. Drop foreign key constraint
            $table->dropForeign(['buyer_id']);
            
            // 2. Rename column
            $table->renameColumn('buyer_id', 'user_id');
        });

        // 3. Add new foreign key
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->renameColumn('user_id', 'buyer_id');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->foreign('buyer_id')
                  ->references('id')
                  ->on('buyers')
                  ->cascadeOnDelete();
        });
    }
};