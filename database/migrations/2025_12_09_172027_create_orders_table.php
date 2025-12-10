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
        $table->string('status')->default('pending'); // pending, paid, shipped, etc.
        $table->timestamps();

        $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
