<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontController::class, 'index'])->name('home');
Route::get('/collection', [FrontController::class, 'collection'])->name('collection');
Route::get('/lookbook', [FrontController::class, 'lookbook'])->name('lookbook');
Route::get('/about', [FrontController::class, 'about'])->name('about');
Route::get('/product/{slug}', [FrontController::class, 'details'])->name('product.details');

Route::get('auth/google', [\App\Http\Controllers\Auth\GoogleController::class, 'redirect'])->name('google.login');
Route::get('auth/google/callback', [\App\Http\Controllers\Auth\GoogleController::class, 'callback'])->name('google.callback');

Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    
    Route::get('/history', [FrontController::class, 'history'])->name('history');

    Route::get('/wallet/topup', [WalletController::class, 'topup'])->name('wallet.topup');
    Route::post('/wallet/topup', [WalletController::class, 'processTopup'])->name('wallet.topup.process');
    
    Route::get('/payment', [PaymentController::class, 'index'])->name('payment.index');
    Route::post('/payment/check', [PaymentController::class, 'check'])->name('payment.check');
    Route::post('/payment/pay', [PaymentController::class, 'pay'])->name('payment.pay');

    Route::middleware('can:seller')->prefix('seller')->name('seller.')->group(function () {
        Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('dashboard');
        Route::get('/products', [SellerController::class, 'products'])->name('products');
        Route::get('/products/create', [SellerController::class, 'createProduct'])->name('products.create');
        Route::post('/products', [SellerController::class, 'storeProduct'])->name('products.store');
        Route::get('/products/{product}/edit', [SellerController::class, 'editProduct'])->name('products.edit');
        Route::put('/products/{product}', [SellerController::class, 'updateProduct'])->name('products.update');
        Route::delete('/products/{product}', [SellerController::class, 'destroyProduct'])->name('products.destroy');
        
        Route::get('/orders', [SellerController::class, 'orders'])->name('orders');
        Route::patch('/orders/{transaction}', [SellerController::class, 'updateOrder'])->name('orders.update');
        
        Route::get('/profile', [SellerController::class, 'profile'])->name('profile');
        Route::put('/profile', [SellerController::class, 'updateProfile'])->name('profile.update');
        Route::get('/balance', [SellerController::class, 'balance'])->name('balance');
        Route::get('/withdrawals', [SellerController::class, 'withdrawals'])->name('withdrawals');
        Route::post('/withdrawals', [SellerController::class, 'storeWithdrawal'])->name('withdrawals.store');
    });

    Route::get('/store/register', [SellerController::class, 'registerStore'])->name('store.register');
    Route::post('/store/register', [SellerController::class, 'storeStore'])->name('store.store');
});

Route::middleware(['auth', 'can:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/verification', [AdminController::class, 'verification'])->name('verification');
    Route::post('/verification/{store}/approve', [AdminController::class, 'approveStore'])->name('verification.approve');
    Route::post('/verification/{store}/reject', [AdminController::class, 'rejectStore'])->name('verification.reject');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy');

    Route::get('/stores', [AdminController::class, 'stores'])->name('stores');
    Route::delete('/stores/{id}', [AdminController::class, 'destroyStore'])->name('stores.destroy');

    Route::get('/withdrawals', [AdminController::class, 'withdrawals'])->name('withdrawals');
    Route::post('/withdrawals/{id}/approve', [AdminController::class, 'approveWithdrawal'])->name('withdrawals.approve');
    Route::post('/withdrawals/{id}/reject', [AdminController::class, 'rejectWithdrawal'])->name('withdrawals.reject');
});

Route::middleware('auth')->group(function () {
    // Generic Dashboard Route for Redirection
    Route::get('/dashboard', function () {
        $user = \Illuminate\Support\Facades\Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        if ($user->role === 'member' && $user->store) {
            return redirect()->route('seller.dashboard');
        }
        return redirect()->route('home');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
