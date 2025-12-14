<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('product_categories')->insert([
            [
                'id'          => 1,
                'parent_id'   => null,
                'image'       => null,
                'name'        => 'Bracelet',
                'slug'        => 'Bracelet',
                'tagline'     => '#gelang #bracelet',
                'description' => 'Bracelet',
            ],
            [
                'id'          => 2,
                'parent_id'   => null,
                'image'       => null,
                'name'        => 'Necklace',
                'slug'        => 'Necklace',
                'tagline'     => '#kalung #necklace',
                'description' => 'Necklace',
            ],
            [
                'id'          => 3,
                'parent_id'   => null,
                'image'       => null,
                'name'        => 'charms',
                'slug'        => 'charms',
                'tagline'     => '#charms #ornamen',
                'description' => 'charms',
            ],
            [
                'id'          => 4,
                'parent_id'   => null,
                'image'       => null,
                'name'        => 'sunglasses',
                'slug'        => 'sunglasses',
                'tagline'     => '#sunglasses #kacamata',
                'description' => 'sunglasses',
            ],
            [
                'id'          => 5,
                'parent_id'   => null,
                'image'       => null,
                'name'        => 'ring',
                'slug'        => 'ring',
                'tagline'     => '#ring #cincin',
                'description' => 'ring',
            ],
        ]);
    }
}
