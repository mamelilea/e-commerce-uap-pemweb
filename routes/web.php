<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductReviewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\SellerProfileController;
use App\Http\Controllers\SellerCategoryController;
use App\Http\Controllers\SellerProductController;
use App\Http\Controllers\SellerOrderController;
use App\Http\Controllers\SellerDashboardController;
use App\Http\Controllers\SellerBalanceController;
use App\Http\Controllers\SellerWithdrawalController;
use App\Http\Controllers\TransactionController;

Route::get('/', [ProductController::class, 'index'])->name('home');

// Detail produk (sementara belum dipakai, nanti untuk show)
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('stores', StoreController::class);

    // CART (pakai session)
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{product}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

    // CHECKOUT SATU PRODUK
    Route::get('/checkout/{product}', [CheckoutController::class, 'start'])->name('checkout.start');
    Route::post('/checkout/{product}', [CheckoutController::class, 'process'])->name('checkout.process');

    // Pesanan saya
    Route::get('/orders', [TransactionController::class, 'index'])->name('orders.index');
    Route::get('/orders/{transaction}', [TransactionController::class, 'show'])->name('orders.show');
    Route::post('/orders/{transaction}/pay', [TransactionController::class, 'pay'])->name('orders.pay');

    // Review
    Route::post('/products/{product}/reviews', [ProductReviewController::class, 'store'])
        ->name('products.reviews.store');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::get('/stores/verification', [AdminController::class, 'storeVerification'])->name('admin.stores.verification');
    Route::post('/stores/{store}/verify', [AdminController::class, 'verifyStore'])->name('admin.stores.verify');
    Route::post('/stores/{store}/reject', [AdminController::class, 'rejectStore'])->name('admin.stores.reject');

    Route::get('/users-stores', [AdminController::class, 'userAndStoreManagement'])->name('admin.users-stores.index');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
});

Route::middleware(['auth'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/', [SellerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [SellerProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [SellerProfileController::class, 'updateStore'])->name('profile.update');
    Route::post('/bank-accounts', [SellerProfileController::class, 'storeBank'])->name('bank.store');
    Route::put('/bank-accounts/{withdrawal}', [SellerProfileController::class, 'updateBank'])->name('bank.update');
    Route::delete('/bank-accounts/{withdrawal}', [SellerProfileController::class, 'destroyBank'])->name('bank.destroy');
    Route::get('/balance', [SellerBalanceController::class, 'index'])->name('balance.index');
    Route::resource('categories', SellerCategoryController::class);
    Route::resource('products', SellerProductController::class);
    Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
    Route::put('/orders/{transaction}', [SellerOrderController::class, 'update'])->name('orders.update');
    Route::post('products/{product}/images', [SellerProductController::class, 'storeImage'])->name('products.images.store');
    Route::delete('products/{product}/images/{image}', [SellerProductController::class, 'destroyImage'])->name('products.images.destroy');
    Route::post('products/{product}/images/{image}/thumbnail', [SellerProductController::class, 'setThumbnail'])->name('products.images.thumbnail');
    Route::get('/withdrawals', [SellerWithdrawalController::class, 'index'])->name('withdrawals.index');
    Route::post('/withdrawals', [SellerWithdrawalController::class, 'store'])->name('withdrawals.store');
});

require __DIR__ . '/auth.php';
