<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Store;

class ManagementController extends Controller
{       
    public function index()
    {
        $stores = Store::with('products.thumbnail')->get(); 
        return view('admin.management', compact('stores'));
    }

    public function management($store_id)
    {
        $store = Store::with('products.thumbnail')->findOrFail($store_id);
        $products = $store->products; // ini hanya produk dari store itu

        return view('admin.management', compact('store', 'products'));
    }

}