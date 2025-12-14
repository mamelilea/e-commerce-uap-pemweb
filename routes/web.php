<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/product/{id}', [App\Http\Controllers\ProductController::class, 'show'])->name('product.show');

Route::middleware(['auth'])->group(function () {
    // Profile Routes
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');


    // Buy Now Route (must be before checkout.index)
    Route::post('/buy-now', [App\Http\Controllers\CheckoutController::class, 'buyNow'])->name('buy.now');
    
    Route::match(['get', 'post'], '/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/history', [App\Http\Controllers\TransactionController::class, 'index'])->name('history.index');
    Route::get('/history/{id}', [App\Http\Controllers\TransactionController::class, 'show'])->name('history.show');
    Route::post('/history/{id}/complete', [App\Http\Controllers\TransactionController::class, 'complete'])->name('history.complete');
    
    // Cart & Wishlist Routes
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [App\Http\Controllers\CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{id}', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [App\Http\Controllers\CartController::class, 'destroy'])->name('cart.remove');
    
    Route::get('/wishlist', [App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist', [App\Http\Controllers\WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{id}', [App\Http\Controllers\WishlistController::class, 'destroy'])->name('wishlist.remove');

    // Wallet Routes
    Route::get('/wallet', [App\Http\Controllers\WalletController::class, 'index'])->name('wallet.index');
    Route::get('/wallet/topup', [App\Http\Controllers\WalletController::class, 'topup'])->name('wallet.topup');
    Route::post('/wallet/topup', [App\Http\Controllers\WalletController::class, 'processTopup'])->name('wallet.process');

    // Seller Routes
    Route::get('/shop/register', [App\Http\Controllers\StoreController::class, 'create'])->name('store.create');
    Route::get('/shop/create', [App\Http\Controllers\StoreController::class, 'create'])->name('store.create');
    Route::post('/shop', [App\Http\Controllers\StoreController::class, 'store'])->name('store.store');
    Route::get('/shop/dashboard', [App\Http\Controllers\StoreController::class, 'index'])->name('store.index');
    Route::get('/shop/edit', [App\Http\Controllers\StoreController::class, 'edit'])->name('store.edit');
    Route::put('/shop', [App\Http\Controllers\StoreController::class, 'update'])->name('store.update');
    Route::delete('/shop', [App\Http\Controllers\StoreController::class, 'destroy'])->name('store.destroy');
    Route::delete('/products/images/{id}', [App\Http\Controllers\SellerProductController::class, 'destroyImage'])->name('store.image.destroy');
    
    // Seller Product Management
    Route::resource('shop/products', App\Http\Controllers\SellerProductController::class)->names([
        'index' => 'seller.products.index',
        'create' => 'seller.products.create',
        'store' => 'seller.products.store',
        'edit' => 'seller.products.edit',
        'update' => 'seller.products.update',
        'destroy' => 'seller.products.destroy',
    ]);

    // Seller Order Management
    Route::get('/shop/orders', [App\Http\Controllers\SellerOrderController::class, 'index'])->name('seller.orders.index');
    Route::post('/shop/orders/{transaction}/ship', [App\Http\Controllers\SellerOrderController::class, 'ship'])->name('seller.orders.ship');
    Route::post('/shop/orders/{transaction}/update-status', [App\Http\Controllers\SellerOrderController::class, 'updateStatus'])->name('seller.orders.update');
    Route::get('/shop/orders/{id}', [App\Http\Controllers\SellerOrderController::class, 'show'])->name('seller.orders.show');
    Route::post('/shop/orders/{transaction}/update-tracking', [App\Http\Controllers\SellerOrderController::class, 'updateTracking'])->name('seller.orders.tracking');


    // Seller Financials
    Route::get('/shop/financials', [App\Http\Controllers\SellerFinancialController::class, 'index'])->name('seller.financials.index');
    Route::get('/shop/financials/balance', [App\Http\Controllers\SellerFinancialController::class, 'balanceHistory'])->name('seller.financials.balance');
    Route::post('/shop/financials', [App\Http\Controllers\SellerFinancialController::class, 'store'])->name('seller.financials.store');
    Route::post('/shop/financials/bank-account', [App\Http\Controllers\SellerFinancialController::class, 'updateBankAccount'])->name('seller.financials.bank');

    // Product Category Management
    Route::get('/shop/categories', [App\Http\Controllers\ProductCategoryController::class, 'index'])->name('seller.categories.index');
    Route::get('/shop/categories/create', [App\Http\Controllers\ProductCategoryController::class, 'create'])->name('seller.categories.create');
    Route::post('/shop/categories', [App\Http\Controllers\ProductCategoryController::class, 'store'])->name('seller.categories.store');
    Route::get('/shop/categories/{id}/edit', [App\Http\Controllers\ProductCategoryController::class, 'edit'])->name('seller.categories.edit');
    Route::put('/shop/categories/{id}', [App\Http\Controllers\ProductCategoryController::class, 'update'])->name('seller.categories.update');
    Route::delete('/shop/categories/{id}', [App\Http\Controllers\ProductCategoryController::class, 'destroy'])->name('seller.categories.destroy');

    // Admin Routes
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('index');
        Route::get('/stores', [App\Http\Controllers\AdminController::class, 'stores'])->name('stores');
        Route::get('/users', [App\Http\Controllers\AdminController::class, 'users'])->name('users');
        Route::post('/store/{id}/verify', [App\Http\Controllers\AdminController::class, 'verifyStore'])->name('store.verify');
        Route::post('/store/{id}/reject', [App\Http\Controllers\AdminController::class, 'rejectStore'])->name('store.reject');
        Route::delete('/store/{id}', [App\Http\Controllers\AdminController::class, 'deleteStore'])->name('store.delete');
        Route::delete('/user/{id}', [App\Http\Controllers\AdminController::class, 'deleteUser'])->name('user.delete');
    });
});

// Payment Simulation (Public for easy access or Protected? Usually public callback, but here sim page)
Route::get('/payment-simulation', [App\Http\Controllers\PaymentController::class, 'index'])->name('payment.simulation');
Route::post('/payment-simulation', [App\Http\Controllers\PaymentController::class, 'pay'])->name('payment.pay');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
