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
    Schema::table('users', function (Blueprint $table) {
        $table->enum('role', ['customer', 'seller', 'admin'])
            ->default('customer')
            ->change();
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->enum('role', ['admin', 'member'])
            ->default('member')
            ->change();
    });
}

};