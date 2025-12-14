<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Store;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $store = Store::where('name', 'wayToCake')->first();

        if (!$store) {
             throw new \Exception("Store 'wayToCake' belum ditemukan. Seeder UserStoreSeeder HARUS dijalankan dulu.");
        }
        $storeId = $store->id;

        DB::table('products')->insert([
            [
                'id'                  => 2,
                'store_id'            => $storeId,
                'product_category_id' => 1,
                'name'                => 'Silver Ribbon Pastel Pink',
                'slug'                => 'Silver-Ribbon-Pastel-Pink',
                'description'         => 'Gelang manik-manik bernuansa pink pastel dengan hiasan ribbon silver.',
                'condition'           => 'new',
                'price'               => 60000,
                'weight'              => 0,
                'stock'               => 102,
            ],
            [
                'id'                  => 3,
                'store_id'            => $storeId,
                'product_category_id' => 1,
                'name'                => 'Monochrome Orbit Bracelet',
                'slug'                => 'Monochrome-Orbit-Bracelet',
                'description'         => 'Gelang charm dengan nuansa hitam–putih yang dipadukan dengan beads elegan.',
                'condition'           => 'new',
                'price'               => 57000,
                'weight'              => 0,
                'stock'               => 80,
            ],
            [
                'id'                  => 4,
                'store_id'            => $storeId,
                'product_category_id' => 2,
                'name'                => 'Cosmic Atlas Necklace',
                'slug'                => 'Cosmic-Atlas-Necklace',
                'description'         => 'Kalung layered bernuansa hitam perak dengan detail ala galaksi.',
                'condition'           => 'new',
                'price'               => 110000,
                'weight'              => 0,
                'stock'               => 50,
            ],
            [
                'id'                  => 5,
                'store_id'            => $storeId,
                'product_category_id' => 2,
                'name'                => 'Lunar Edge Chain',
                'slug'                => 'Lunar-Edge-Chain',
                'description'         => 'Kalung multi-layer berbahan silver dengan charm bertema bulan.',
                'condition'           => 'new',
                'price'               => 132000,
                'weight'              => 0,
                'stock'               => 30,
            ],
            [
                'id'                  => 6,
                'store_id'            => $storeId,
                'product_category_id' => 3,
                'name'                => 'Starwave Melody',
                'slug'                => 'Starwave-Melody',
                'description'         => 'Charm gantung dengan kombinasi beads biru lembut dan aksen bintang.',
                'condition'           => 'new',
                'price'               => 32000,
                'weight'              => 5,
                'stock'               => 21,
            ],
            [
                'id'                  => 7,
                'store_id'            => $storeId,
                'product_category_id' => 3,
                'name'                => 'Midnight 8-Ball Charms',
                'slug'                => 'Midnight-8-Ball-Charms',
                'description'         => 'Charm edgy dengan bag charm bergaya Cyber Grunge 8-ball.',
                'condition'           => 'new',
                'price'               => 38000,
                'weight'              => 42,
                'stock'               => 40,
            ],
            [
                'id'                  => 8,
                'store_id'            => $storeId,
                'product_category_id' => 3,
                'name'                => 'Strawberry Beats Charms',
                'slug'                => 'Strawberry-Beats-Charms',
                'description'         => 'Gantungan kunci super cute yang menggabungkan estetika strawberry dan musik.',
                'condition'           => 'new',
                'price'               => 27000,
                'weight'              => 28,
                'stock'               => 35,
            ],
            [
                'id'                  => 9,
                'store_id'            => $storeId,
                'product_category_id' => 5,
                'name'                => 'Constellation Stack Ring',
                'slug'                => 'Constellation-Stack-Ring',
                'description'         => 'Cincin cut-out bermotif bintang yang bisa di-stack.',
                'condition'           => 'new',
                'price'               => 73000,
                'weight'              => 50,
                'stock'               => 28,
            ],
            [
                'id'                  => 10,
                'store_id'            => $storeId,
                'product_category_id' => 5,
                'name'                => 'Hollow Star Ring',
                'slug'                => 'Hollow-Star-Ring',
                'description'         => 'Cincin statement dengan desain bintang tunggal yang hollow.',
                'condition'           => 'new',
                'price'               => 64000,
                'weight'              => 52,
                'stock'               => 70,
            ],
            [
                'id'                  => 11,
                'store_id'            => $storeId,
                'product_category_id' => 4,
                'name'                => 'Double Hoop Frames',
                'slug'                => 'Double-Hoop-Frames',
                'description'         => 'Kacamata hitam berbingkai oval transparan dengan double hoop frame.',
                'condition'           => 'new',
                'price'               => 105000,
                'weight'              => 38,
                'stock'               => 200,
            ],
            [
                'id'                  => 12,
                'store_id'            => $storeId,
                'product_category_id' => 4,
                'name'                => 'Reactor Shades Sunglasses',
                'slug'                => 'Reactor-Shades-Sunglasses',
                'description'         => 'Kacamata statement piece dengan desain futuristik tebal.',
                'condition'           => 'new',
                'price'               => 127000,
                'weight'              => 43,
                'stock'               => 186,
            ],
        ]);
    }
}
