<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Seller\DashboardController;
use App\Http\Middleware\CheckSeller;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Seller\ProductCategoryController;
use App\Http\Controllers\Seller\ProductController;
use App\Http\Controllers\Seller\StoreController;
use App\Http\Controllers\Customer\CustomerHomeController;
use App\Http\Controllers\Customer\TransactionController;
use App\Http\Controllers\CartController;

// Homepage
Route::get('/', [CustomerHomeController::class, 'index'])->name('customer.home');
Route::get('/search', [CustomerHomeController::class, 'search'])->name('customer.search');

// Dashboard & Profile
Route::get('/dashboard', function () {
    return redirect()->route('customer.home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Store Registration (For Customers trying to become Sellers)
    Route::get('/store/register', [StoreController::class, 'create'])->name('store.register');
    Route::post('/store/register', [StoreController::class, 'store'])->name('store.store');
});

Route::middleware(['auth', 'verified', CheckSeller::class])
    ->prefix('seller/dashboard')
    ->name('seller.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('categories', ProductCategoryController::class);
        Route::resource('products', ProductController::class);

        Route::controller(StoreController::class)->group(function () {
            Route::get('/manage', 'manage')->name('store.manage');
            Route::put('/manage', 'update')->name('store.update');
            Route::delete('/manage', 'destroy')->name('store.destroy');
        });

        // Placeholder Routes for Sidebar
        Route::controller(\App\Http\Controllers\Seller\OrderController::class)->group(function () {
            Route::get('/orders', 'index')->name('orders.index');
            Route::get('/orders/{id}', 'show')->name('orders.show');
            Route::put('/orders/{id}', 'update')->name('orders.update');
            Route::post('/orders/{id}/confirm', 'confirm')->name('orders.confirm');
            Route::post('/orders/{id}/reject', 'reject')->name('orders.reject');
        });
        Route::controller(\App\Http\Controllers\Seller\BalanceController::class)->prefix('balance')->name('balance.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/bank', 'updateBank')->name('updateBank');
            Route::get('/withdraw', 'withdraw')->name('withdraw');
            Route::post('/withdraw', 'processWithdraw')->name('processWithdraw');
        });
    });

// Customer Product & Transaction Routes
Route::get('/products/{id}', [CustomerHomeController::class, 'show'])->name('customer.product.show');

// Consolidating Transaction Routes
// Using the 'transaction.show' name for proper linking
Route::middleware('auth')->group(function () {
    // Checkout/Transaction Process
    Route::get('/checkout/{product}', [TransactionController::class, 'show'])->name('transaction.show');
    Route::post('/checkout', [TransactionController::class, 'process'])->name('transaction.process');
    
    // Transaction History & Details
    Route::get('/transactions', [TransactionController::class, 'history'])->name('transaction.history');
    Route::get('/transactions/{transaction}', [TransactionController::class, 'detail'])->name('transaction.detail');
    Route::post('/transaction/{transaction}/confirm', [TransactionController::class, 'confirm'])->name('transaction.confirm');
    Route::post('/transaction/{transaction}/upload-proof', [TransactionController::class, 'uploadProof'])->name('transaction.upload_proof');
    Route::post('/transaction/{transaction}/complete', [TransactionController::class, 'complete'])->name('transaction.complete');
    Route::post('/transaction/{transaction}/review', [TransactionController::class, 'storeReview'])->name('transaction.review');
    
});

// Public Cart Routes (Auth + Guest)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');
    Route::get('/verification', [\App\Http\Controllers\AdminController::class, 'verification'])->name('verification');
    Route::get('/management', [\App\Http\Controllers\AdminController::class, 'management'])->name('management');
    Route::post('/store/{id}/verify', [\App\Http\Controllers\AdminController::class, 'verifyStore'])->name('store.verify');
    
    // Payment Verification
    Route::get('/payment-verification', [\App\Http\Controllers\AdminController::class, 'paymentVerification'])->name('payment.verification');
    Route::post('/payment-verification/{id}', [\App\Http\Controllers\AdminController::class, 'verifyPayment'])->name('payment.verify');

    // Withdrawal Verification
    Route::get('/withdrawal-verification', [\App\Http\Controllers\AdminController::class, 'withdrawalVerification'])->name('withdrawal.verification');
    Route::post('/withdrawal-verification/{id}', [\App\Http\Controllers\AdminController::class, 'verifyWithdrawal'])->name('withdrawal.verify');
});

require __DIR__ . '/auth.php';
