<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Seller\SellerStoreController;
use App\Http\Controllers\Seller\SellerOrderController;
use App\Http\Controllers\Seller\SellerDashboardController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\User\HomepageController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\User\HistoryController;
use App\Http\Controllers\Admin\AdminController;

// ================== HOMEPAGE ==================

Route::get('/', [HomepageController::class, 'indexGuest'])->name('home');

Route::get('/dashboard', [HomepageController::class, 'indexAuth'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// ================== DETAIL PRODUK ==================
// Detail produk via slug (URL: /produk/slug-produk)
Route::get('/produk/{slug}', [ProductController::class, 'detail'])->name('product.detail');

// ================== CHECKOUT ==================

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

// ================== KATEGORI & API PRODUK ==================

Route::get('/category/{slug}', [HomepageController::class, 'getByCategory'])->name('category.products');
Route::get('/api/all-products', [HomepageController::class, 'allProducts'])->name('api.all-products');

// ================== PROFILE & HISTORY (AUTH) ==================

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
});

// ================== ADMIN PANEL ==================

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // DASHBOARD
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // ========== VERIFIKASI TOKO ==========
        Route::get('/stores/verification', [AdminController::class, 'storeVerification'])->name('stores.verification');
        Route::post('/stores/{store}/verify', [AdminController::class, 'verifyStore'])->name('stores.verify');
        Route::delete('/stores/{store}/reject', [AdminController::class, 'rejectStore'])->name('stores.reject');

        // ========== MANAJEMEN USER & TOKO ==========
        Route::get('/users-stores', [AdminController::class, 'userAndStoreManagement'])->name('users-stores.index');
        Route::get('/users-stores/{user}/edit', [AdminController::class, 'editUser'])->name('users-stores.edit');
        Route::put('/users-stores/{user}', [AdminController::class, 'updateUser'])->name('users-stores.update');
        Route::delete('/users-stores/{user}', [AdminController::class, 'destroyUser'])->name('users-stores.destroy');
    });

// ================== PRODUCT ROUTES (LISTING, BY CATEGORY, SHOW) ==================

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/category/{slug}', [ProductController::class, 'byCategory'])->name('products.by-category');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// ================== SELLER ==================

Route::middleware(['auth'])
    ->prefix('seller')
    ->name('seller.')
    ->group(function () {

        // REGISTER TOKO (tidak butuh middleware seller)
        Route::get('/register-store', [SellerStoreController::class, 'create'])->name('store.create');
        Route::post('/register-store', [SellerStoreController::class, 'store'])->name('store.store');

        // WAITING VERIFICATION (akses ketika toko BELUM terverifikasi)
        Route::get('/waiting-verification', [SellerDashboardController::class, 'waitingVerification'])
            ->name('waiting');

        // ROUTE KHUSUS SELLER YG SUDAH TERVERIFIKASI (middleware 'seller')
        Route::middleware('seller')->group(function () {
            // Dashboard Seller
            Route::get('/dashboard', [SellerDashboardController::class, 'index'])->name('dashboard');

            // Manajemen pesanan
            Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
            Route::get('/orders/{transaction}', [SellerOrderController::class, 'show'])->name('orders.show');
            Route::put('/orders/{transaction}', [SellerOrderController::class, 'update'])->name('orders.update');
        });
    });

require __DIR__.'/auth.php';
