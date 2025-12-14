<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('product_images')->insert([
            [
                'product_id'   => 2,
                'image'        => 'products/gelang1.jpeg',
                'is_thumbnail' => 1,
            ],
            [
                'product_id'   => 3,
                'image'        => 'products/gelang2.jpeg',
                'is_thumbnail' => 1,
            ],
            [
                'product_id'   => 4,
                'image'        => 'products/kalung1.jpeg',
                'is_thumbnail' => 1,
            ],
            [
                'product_id'   => 5,
                'image'        => 'products/kalung2.jpeg',
                'is_thumbnail' => 1,
            ],
            [
                'product_id'   => 6,
                'image'        => 'products/charms1.jpeg',
                'is_thumbnail' => 1,
            ],
            [
                'product_id'   => 7,
                'image'        => 'products/charms2.jpeg',
                'is_thumbnail' => 1,
            ],
            [
                'product_id'   => 8,
                'image'        => 'products/charms3.jpeg',
                'is_thumbnail' => 1,
            ],
            [
                'product_id'   => 9,
                'image'        => 'products/ring1.jpeg',
                'is_thumbnail' => 1,
            ],
            [
                'product_id'   => 10,
                'image'        => 'products/ring2.jpeg',
                'is_thumbnail' => 1,
            ],
            [
                'product_id'   => 11,
                'image'        => 'products/sunglasses1.jpeg',
                'is_thumbnail' => 1,
            ],
            [
                'product_id'   => 12,
                'image'        => 'products/sunglasses2.jpeg',
                'is_thumbnail' => 1,
            ],
        ]);
    }
}
