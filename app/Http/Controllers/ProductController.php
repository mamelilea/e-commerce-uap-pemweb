<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Homepage / dashboard untuk guest & user: daftar produk + filter kategori
     */
    public function index(Request $request)
    {
        // Ambil semua kategori untuk filter
        $categories = ProductCategory::orderBy('name')->get();

        $productsQuery = Product::with(['store', 'productImages', 'productCategory']);

        // --- 🔍 Ambil keyword search dari query string ?q= ---
        $search = trim($request->query('q'));

        // Filter kategori pakai slug di query string: ?category=slug-kategori
        $activeCategorySlug = $request->query('category');

        if ($activeCategorySlug) {
            $productsQuery->whereHas('productCategory', function ($q) use ($activeCategorySlug) {
                $q->where('slug', $activeCategorySlug);
            });
        }

        // --- 🔍 Jika ada keyword, filter produk berdasarkan nama, deskripsi, atau nama toko ---
        if ($search !== '') {
            $productsQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('store', function ($storeQuery) use ($search) {
                        $storeQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Bisa ditambah order sesuai kebutuhan (created_at terbaru dulu)
        $products = $productsQuery->latest()->paginate(12)->withQueryString();

        return view('products.index', [
            'categories'         => $categories,
            'products'           => $products,
            'activeCategorySlug' => $activeCategorySlug,
        ]);
    }

    /**
     * Detail 1 produk (guest boleh akses).
     * Sekaligus data ulasan & info apakah user boleh mengulas.
     */
    public function show(Product $product)
    {
        $product->load([
            'store.user',
            'productImages',
            'productCategory',
            'productReviews.transaction.user',
        ]);

        $reviews      = $product->productReviews()->latest()->get();
        $reviewsCount = $reviews->count();
        $averageRating = $reviewsCount > 0 ? round($reviews->avg('rating'), 1) : null;

        $canReview   = false;
        $hasReviewed = false;

        if (Auth::check()) {
            $user = Auth::user();

            // Cari transaction detail untuk user ini & produk ini
            $transactionDetail = $product->transactionDetails()
                ->whereHas('transaction', function ($q) use ($user) {
                    // PASTIKAN kolom 'buyer_id' ini sesuai dg kolom di tabel transactions
                    $q->where('buyer_id', $user->id);
                })
                ->latest()
                ->first();

            if ($transactionDetail) {
                $transaction = $transactionDetail->transaction;

                $hasReviewed = ProductReview::where('product_id', $product->id)
                    ->where('transaction_id', $transaction->id)
                    ->exists();

                $canReview = ! $hasReviewed;
            }
        }

        return view('products.show', compact(
            'product',
            'reviews',
            'reviewsCount',
            'averageRating',
            'canReview',
            'hasReviewed',
        ));
    }
}
