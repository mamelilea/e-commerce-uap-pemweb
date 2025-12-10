<?php

use App\Models\Store;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $store = Store::find(1);
    if ($store) {
        echo "Current Name: " . $store->name . "\n";
        $store->name = 'Evernext Phone';
        $store->slug = \Illuminate\Support\Str::slug('Evernext Phone');
        $store->save();
        echo "New Name: " . $store->name . "\n";
    } else {
        echo "Store ID 1 not found.\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
