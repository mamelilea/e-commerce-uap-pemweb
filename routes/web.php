<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{product:slug}', [HomeController::class, 'product'])->name('product.detail');

Route::get('/checkout/{product:slug}', [HomeController::class, 'checkout'])->middleware(['auth'])->name('checkout');
Route::post('/checkout/{product:slug}', [App\Http\Controllers\TransactionController::class, 'store'])->middleware(['auth'])->name('checkout.store');




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/my-orders', [App\Http\Controllers\HomeController::class, 'history'])->name('orders.history');
    
    Route::get('/cart/checkout', [App\Http\Controllers\CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/cart/checkout', [App\Http\Controllers\CartController::class, 'processCheckout'])->name('cart.checkout.process');
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/{product}', [App\Http\Controllers\CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{cart}', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [App\Http\Controllers\CartController::class, 'destroy'])->name('cart.destroy');
    Route::patch('/orders/{transaction}/complete', [TransactionController::class, 'complete'])->name('orders.complete');
    
    Route::get('/orders/{transaction}/rate', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::patch('/store/{store}/approve', [AdminController::class, 'approveStore'])->name('store.approve');
    Route::patch('/store/{store}/suspend', [AdminController::class, 'suspendStore'])->name('store.suspend');
    Route::delete('/store/{store}', [AdminController::class, 'destroyStore'])->name('store.destroy');
    Route::patch('/withdrawal/{withdrawal}/approve', [AdminController::class, 'approveWithdrawal'])->name('withdrawal.approve');
});

Route::middleware(['auth', 'role:seller', 'store.active'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('dashboard');
    Route::get('/products', [SellerController::class, 'products'])->name('products.index');
    Route::get('/products/create', [SellerController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [SellerController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{product}/edit', [SellerController::class, 'editProduct'])->name('products.edit');
    Route::patch('/products/{product}', [SellerController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{product}', [SellerController::class, 'destroyProduct'])->name('products.destroy');
    
    Route::get('/orders', [SellerController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{transaction}', [SellerController::class, 'showOrder'])->name('orders.show');
    Route::patch('/orders/{transaction}', [SellerController::class, 'updateOrder'])->name('orders.update');

    Route::get('/store/edit', [SellerController::class, 'editStore'])->name('store.edit');
    Route::patch('/store', [SellerController::class, 'updateStore'])->name('store.update');

    Route::get('/balance', [App\Http\Controllers\StoreBalanceController::class, 'index'])->name('balance.index');
    Route::patch('/balance/bank', [App\Http\Controllers\StoreBalanceController::class, 'updateBank'])->name('balance.bank');
    Route::post('/balance/withdraw', [App\Http\Controllers\StoreBalanceController::class, 'withdraw'])->name('balance.withdraw');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/open-store', [SellerController::class, 'registerStore'])->name('seller.register');
    Route::post('/open-store', [SellerController::class, 'storeStore'])->name('seller.store');
});


require __DIR__.'/auth.php';
