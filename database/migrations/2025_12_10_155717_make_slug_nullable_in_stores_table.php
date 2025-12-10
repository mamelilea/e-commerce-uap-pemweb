<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            // CUMA bikin nullable, JANGAN pakai ->unique() lagi
            $table->string('slug')->nullable()->change();

            // Optional: kalau mau logo boleh null juga
            $table->string('logo')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            // Balik lagi jadi NOT NULL
            $table->string('slug')->nullable(false)->change();
            $table->string('logo')->nullable(false)->change();
        });
    }
};
