<?php

use App\Models\Store;
use App\Models\Product;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    // Update Store Name
    $store = Store::find(1);
    if ($store) {
        $store->name = 'Evernext Phone';
        $store->slug = \Illuminate\Support\Str::slug('Evernext Phone');
        $store->save();
        echo "Store updated to Evernext Phone.\n";
    }

    // Update Product Description
    $product = Product::where('slug', 'samsung-galaxy-s23-ultra')->first();
    if ($product) {
        $product->description = "Samsung Galaxy S23 Ultra mendefinisikan ulang standar smartphone flagship. Ditenagai oleh chipset Snapdragon 8 Gen 2 for Galaxy yang super cepat, layar Dynamic AMOLED 2X 120Hz yang memukau, dan kamera utama 200MP untuk detail foto yang luar biasa. Baterai 5000mAh tahan seharian, S Pen terintegrasi untuk produktivitas maksimal, dan desain premium yang elegan menjadikan S23 Ultra pilihan utama bagi profesional dan kreator konten.";
        $product->save();
        echo "Product description updated.\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
