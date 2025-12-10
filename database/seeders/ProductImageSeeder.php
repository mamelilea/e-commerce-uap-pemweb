<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;

class ProductImageSeeder extends Seeder
{
    public function run()
    {
        $products = Product::all();

        if ($products->isEmpty()) {
            $this->command->info('Tidak ada produk, seeding dibatalkan.');
            return;
        }

        foreach ($products as $product) {
            // Buat 1 thumbnail
            ProductImage::create([
                'product_id' => $product->id,
                'image' => 'thumbnail-' . $product->id . '.jpg',
                'is_thumbnail' => 1,
            ]);

            // Buat 2-3 gambar tambahan
            $extraImages = rand(2, 3);
            for ($i = 1; $i <= $extraImages; $i++) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => 'product-' . $product->id . '-' . $i . '.jpg',
                    'is_thumbnail' => 0,
                ]);
            }
        }
    }
}
