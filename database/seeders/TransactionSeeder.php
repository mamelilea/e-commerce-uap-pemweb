<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;
use App\Models\Buyer;
use Illuminate\Support\Str;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil produk Samsung Galaxy S23 Ultra
        $product = Product::where('slug', 'samsung-galaxy-s23-ultra')->first();

        if (!$product) {
            $this->command->error("Produk 'Samsung Galaxy S23 Ultra' tidak ditemukan. Pastikan sudah ada di tabel products.");
            return;
        }

        // 2. Ambil toko dari produk tersebut
        $store = $product->store;
        if (!$store) {
            $this->command->error("Produk tidak memiliki store terkait. Pastikan relasi product->store sudah benar.");
            return;
        }

        // 3. Ambil satu buyer
        $buyer = Buyer::first();
        if (!$buyer) {
            $this->command->error("Tidak ada buyer di database. Daftarkan user buyer dulu (otomatis dari register) atau buat seeder buyer.");
            return;
        }

        // 4. Buat beberapa transaksi dummy untuk produk ini
        for ($i = 1; $i <= 5; $i++) {

            $qty = rand(1, 3); // jumlah barang
            $subtotal = $product->price * $qty; // total harga barang
            $shippingCost = 20000; // ongkir contoh
            $tax = round($subtotal * 0.11, 2); // PPN 11% contoh
            $grandTotal = $subtotal + $shippingCost + $tax;

            $transaction = Transaction::create([
                'code'           => 'TRX-S23-' . strtoupper(Str::random(4)),
                'buyer_id'       => $buyer->id,
                'store_id'       => $store->id,
                'address'        => 'Jalan Contoh No. ' . rand(1, 200) . ', Kecamatan Sukun',
                'address_id'     => 'ADDR-' . rand(1000, 9999),
                'city'           => 'Malang',
                'postal_code'    => '651xx',
                'shipping'       => 'JNE',
                'shipping_type'  => 'Reguler',
                'shipping_cost'  => $shippingCost,
                'tracking_number'=> $i <= 3 ? 'RESI-S23-' . rand(100000, 999999) : null, // sebagian sudah ada resi
                'tax'            => $tax,
                'grand_total'    => $grandTotal,
                'payment_status' => $i <= 3 ? 'paid' : 'unpaid',
            ]);

            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id'     => $product->id,
                'qty'            => $qty,
                'subtotal'       => $subtotal,
            ]);
        }

        $this->command->info("5 transaksi dummy untuk Samsung Galaxy S23 Ultra berhasil dibuat.");
    }
}
