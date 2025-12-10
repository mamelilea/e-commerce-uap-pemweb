<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminTransactionController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\SellerOrderController;
use App\Http\Controllers\SellerProductController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\MyOrderController;
use App\Http\Controllers\StoreController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/products', [ProductController::class, 'index'])->name('products.list');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.detail');
Route::get('/store/{name}', [StoreController::class, 'show'])->name('store.show');

Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->middleware('verified')->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{code}', [CheckoutController::class, 'success'])->name('checkout.success');

    Route::post('/reviews', [ProductReviewController::class, 'store'])->name('reviews.store');

    Route::get('/my-order', [MyOrderController::class, 'index'])->name('my-order');
    Route::get('/my-order/{code}', [MyOrderController::class, 'show'])->name('my-order.detail');
    Route::post('/my-order/{code}/complete', [MyOrderController::class, 'complete'])->name('my-order.complete');

    Route::get('/join-seller', [SellerController::class, 'showJoinPage'])->name('join-seller');
    Route::post('/join-seller', [SellerController::class, 'registerStore'])->name('join-seller.store');

    Route::middleware('role:seller')->prefix('seller')->name('seller.')->group(function () {
        Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('dashboard');
        
        Route::get('/store', [SellerController::class, 'editStore'])->name('store');
        Route::post('/store', [SellerController::class, 'updateStore'])->name('store.update');

        Route::get('/products', [SellerProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [SellerProductController::class, 'create'])->name('products.create');
        Route::post('/products', [SellerProductController::class, 'store'])->name('products.store');
        Route::get('/products/{id}/edit', [SellerProductController::class, 'edit'])->name('products.edit');
        Route::post('/products/{id}', [SellerProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{id}', [SellerProductController::class, 'destroy'])->name('products.destroy');
        Route::delete('/product-images/{id}', [SellerProductController::class, 'destroyImage'])->name('products.image.destroy');

        Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
        Route::patch('/orders/{id}/resi', [SellerOrderController::class, 'updateResi'])->name('orders.resi');
        
        Route::get('/balance', [SellerController::class, 'balance'])->name('balance');
        Route::post('/balance/withdraw', [SellerController::class, 'withdraw'])->name('balance.withdraw');
    });

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        Route::get('/transactions', [AdminTransactionController::class, 'index'])->name('transactions');
        Route::patch('/transactions/{id}/confirm', [AdminTransactionController::class, 'confirm'])->name('transactions.confirm');

        Route::get('/stores', [AdminController::class, 'stores'])->name('stores');
        Route::patch('/stores/{id}/approve', [AdminController::class, 'approveStore'])->name('stores.approve');
        Route::delete('/stores/{id}/reject', [AdminController::class, 'rejectStore'])->name('stores.reject');
        
        Route::get('/withdrawals', [AdminController::class, 'withdrawals'])->name('withdrawals');
        Route::patch('/withdrawals/{id}/approve', [AdminController::class, 'approveWithdrawal'])->name('withdrawals.approve');
        Route::patch('/withdrawals/{id}/reject', [AdminController::class, 'rejectWithdrawal'])->name('withdrawals.reject');
        
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    });
});

require __DIR__.'/auth.php';