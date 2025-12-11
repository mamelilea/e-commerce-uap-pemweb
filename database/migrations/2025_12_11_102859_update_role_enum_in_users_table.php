<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // ganti enum lama menjadi enum baru
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'seller', 'customer') NOT NULL DEFAULT 'customer'");
    }

    public function down(): void
    {
        // rollback ke enum sebelumnya
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'member') NOT NULL DEFAULT 'member'");
    }
};
