<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Inertia\Inertia; 

class StoreViewController extends Controller
{
    /**
     * Menampilkan halaman detail profil toko untuk pembeli
     */
    public function show($id)
    {
        try {
            // Mengambil data Toko: 
            // - 'user' (pemilik toko)
            // - 'products.productImages' (produk dan gambar utama)
            // - Menghitung total ulasan (product_reviews_count)
            // - Menghitung rata-rata rating (product_reviews_avg_rating)
            $store = Store::with(['products.productImages', 'user'])
                          ->withCount('productReviews') 
                          ->withAvg('productReviews', 'rating') 
                          ->findOrFail($id);
            
            // Render komponen React Inertia dan kirim data yang sudah diformat
            return Inertia::render('StoreProfile', [
                'store' => [
                    'id' => $store->id,
                    'name' => $store->name,
                    'logo' => $store->logo,
                    'description' => $store->about, // Mengambil dari kolom 'about'
                    'phone' => $store->phone,
                    'address' => $store->address,
                    'city' => $store->city,
                    'joined_date' => $store->joined_date, // Dari Accessor
                    // Rating dibulatkan ke 1 desimal
                    'rating' => round($store->product_reviews_avg_rating ?? 0, 1), 
                    'reviews_count' => $store->product_reviews_count,
                    'owner_name' => $store->user->name,
                    
                    // Memformat produk
                    'products' => $store->products->map(function ($product) {
                        return [
                            'id' => $product->id,
                            'name' => $product->name,
                            'slug' => $product->slug,
                            'price' => $product->price,
                            // Ambil gambar produk pertama sebagai gambar utama
                            'main_image' => $product->productImages->first()->image_url ?? '/images/default-product.png', 
                        ];
                    }),
                ],
                'auth' => [
                    'user' => auth()->user() ? auth()->user()->only('id', 'name', 'email') : null,
                ]
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Jika toko tidak ditemukan
            return redirect()->route('welcome')->with('error', 'Toko tidak ditemukan.');
        }
    }
}