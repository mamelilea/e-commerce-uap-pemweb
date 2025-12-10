<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    if (!Schema::hasTable('orders')) {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('nama');
            $table->string('telepon');
            $table->text('alamat');
            $table->string('kota');
            $table->string('kodepos');
            $table->string('pengiriman');
            $table->string('payment');
            $table->integer('subtotal');
            $table->integer('ongkir');
            $table->integer('total');
            $table->string('status')->default('pending');
            $table->timestamps();
            
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
        echo "Table 'orders' created successfully.";
    } else {
        echo "Table 'orders' already exists.";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
