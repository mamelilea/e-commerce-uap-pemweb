<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/search', [ProductController::class, 'search'])->name('products.search');

// Cart Routes (requires auth)
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{productId}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{productId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

    // Wishlist Routes (requires auth)
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::delete('/wishlist/{productId}', [WishlistController::class, 'remove'])->name('wishlist.remove');
});

// Checkout Routes (requires auth)
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{transaction}', [CheckoutController::class, 'success'])->name('checkout.success');
    
    // Transaction Routes
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');

    // Reviews
    Route::post('/reviews', [App\Http\Controllers\ProductReviewController::class, 'store'])->name('reviews.store');
});

// Dashboard (for authenticated users)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Seller Routes
use App\Http\Controllers\Seller\SellerProductController;
use App\Http\Controllers\Seller\SellerOrderController;
use App\Http\Controllers\Seller\SellerBalanceController;
use App\Http\Controllers\Seller\WithdrawalController;

// Store Registration (no store required)
Route::middleware(['auth'])->prefix('seller')->group(function () {
    Route::get('/register', [StoreController::class, 'create'])->name('seller.register');
    Route::post('/register', [StoreController::class, 'store'])->name('seller.store');
    Route::get('/pending', function() {
        return view('seller.pending');
    })->name('seller.pending');
});

// Seller Dashboard (requires store and verification)
Route::middleware(['auth', 'has.store', 'store.verified'])->prefix('seller')->name('seller.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [StoreController::class, 'dashboard'])->name('dashboard');
    
    // Store Management
    Route::get('/store/edit', [StoreController::class, 'edit'])->name('store.edit');
    Route::put('/store', [StoreController::class, 'update'])->name('store.update');
    
    // Products
    Route::resource('products', SellerProductController::class);
    Route::delete('/images/{image}', [SellerProductController::class, 'deleteImage'])->name('images.delete');
    
    // Orders
    Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{transaction}', [SellerOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{transaction}/status', [SellerOrderController::class, 'updateStatus'])->name('orders.status');
    Route::patch('/orders/{transaction}/tracking', [SellerOrderController::class, 'addTracking'])->name('orders.tracking');
    
    // Balance
    Route::get('/balance', [SellerBalanceController::class, 'index'])->name('balance.index');
    
    // Withdrawals
    Route::get('/withdrawals', [WithdrawalController::class, 'index'])->name('withdrawals.index');
    Route::post('/withdrawals', [WithdrawalController::class, 'store'])->name('withdrawals.store');
    Route::put('/withdrawals/bank', [WithdrawalController::class, 'updateBankAccount'])->name('withdrawals.bank');
});

// Admin Panel (requires admin role)
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\StoreVerificationController;
use App\Http\Controllers\Admin\WithdrawalApprovalController;
use App\Http\Controllers\Admin\UserManagementController;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    
    // Store Verification
    Route::get('/stores', [StoreVerificationController::class, 'index'])->name('stores.index');
    Route::get('/stores/all', [StoreVerificationController::class, 'all'])->name('stores.all');
    Route::get('/stores/{store}', [StoreVerificationController::class, 'show'])->name('stores.show');
    Route::post('/stores/{store}/approve', [StoreVerificationController::class, 'approve'])->name('stores.approve');
    Route::post('/stores/{store}/reject', [StoreVerificationController::class, 'reject'])->name('stores.reject');
    Route::delete('/stores/{store}', [UserManagementController::class, 'deleteStore'])->name('stores.delete');
    
    // User Management
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::delete('/users/{user}', [UserManagementController::class, 'deleteUser'])->name('users.delete');
    
    // Withdrawal Approval
    Route::get('/withdrawals', [WithdrawalApprovalController::class, 'index'])->name('withdrawals.index');
    Route::post('/withdrawals/{withdrawal}/approve', [WithdrawalApprovalController::class, 'approve'])->name('withdrawals.approve');
    Route::post('/withdrawals/{withdrawal}/reject', [WithdrawalApprovalController::class, 'reject'])->name('withdrawals.reject');

});


require __DIR__.'/auth.php';
