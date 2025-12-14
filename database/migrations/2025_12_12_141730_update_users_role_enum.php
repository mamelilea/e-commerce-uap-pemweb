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
        // For MySQL, we need to use raw SQL to modify enum
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'member', 'seller') DEFAULT 'member'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum (be careful, this will fail if there are 'seller' values)
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'member') DEFAULT 'member'");
    }
};
