<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\StoreBalanceController;
use App\Http\Controllers\StoreWithdrawalController;
use App\Http\Controllers\SellerProductController;
use App\Http\Controllers\AdminStoreController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');


// Home pengguna
Route::get('/pengguna/home', [ProductController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('pengguna.home');

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Detail produk
Route::get('/product/{id}', [ProductController::class, 'detail'])
    ->name('pengguna.detail');

// Admin dashboard
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('admin.dashboard');

// Register toko
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/toko/register', [StoreController::class, 'create'])->name('toko.register');
    Route::post('/toko/register', [StoreController::class, 'store'])->name('toko.store');
});

// Dashboard toko
Route::get('/toko/dashboard', function () {
    return view('toko.dashboard');
})->middleware(['auth', 'verified'])->name('toko.dashboard');

// Orders toko
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/toko/orders', [StoreController::class, 'orders'])->name('toko.orders.home');
    Route::get('/toko/orders/{id}', [StoreController::class, 'orderDetail'])->name('toko.orders.show');
    Route::post('/toko/orders/{id}/status', [StoreController::class, 'updateStatus'])->name('toko.orders.updateStatus');
    Route::post('/toko/orders/{id}/resi', [StoreController::class, 'updateResi'])->name('toko.orders.updateResi');
});

// SALDO & PENARIKAN
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/toko/saldo', [StoreBalanceController::class, 'index'])->name('toko.saldo.index');
    Route::get('/toko/penarikan', [StoreWithdrawalController::class, 'index'])->name('toko.withdraw.home');
    Route::post('/toko/penarikan', [StoreWithdrawalController::class, 'withdraw'])->name('toko.withdraw.submit');
});

// -----------------------
// Produk toko CRUD
// -----------------------
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/toko/products', [SellerProductController::class, 'index'])->name('toko.products.index');
    Route::get('/toko/products/create', [SellerProductController::class, 'create'])->name('toko.products.create');
    Route::post('/toko/products/store', [SellerProductController::class, 'store'])->name('toko.products.store');
    Route::get('/toko/products/{id}/edit', [SellerProductController::class, 'edit'])->name('toko.products.edit');
    Route::post('/toko/products/{id}/update', [SellerProductController::class, 'update'])->name('toko.products.update');
    Route::delete('/toko/products/{id}', [SellerProductController::class, 'destroy'])->name('toko.products.delete');
});

// Category pengguna
Route::get('/pengguna/category', [CategoryController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('pengguna.category');

Route::get('/checkout/{product}', [CheckoutController::class, 'index'])
    ->name('pengguna.cekout')
    ->middleware('auth');

Route::get('/checkout/transaction/{transaction}', [CheckoutController::class, 'show'])
    ->name('pengguna.cekout.show')
    ->middleware('auth');

Route::get('/checkout/{product}/alamat', [CheckoutController::class, 'address'])
    ->name('pengguna.alamat')
    ->middleware('auth');

Route::post('/checkout/{product}/alamat', [CheckoutController::class, 'storeAddress'])
    ->name('pengguna.alamat.store')
    ->middleware('auth');

Route::get('/checkout/{product}/pengiriman', [CheckoutController::class, 'shipping'])
    ->name('pengguna.pengiriman')
    ->middleware('auth');

Route::post('/checkout/{product}/pengiriman', [CheckoutController::class, 'storeShipping'])
    ->name('pengguna.pengiriman.store')
    ->middleware('auth');
    
Route::get('/checkout/{product}/metodepembayaran', [CheckoutController::class, 'payment'])
    ->name('pengguna.metodepembayaran')
    ->middleware('auth');

Route::post('/checkout/{product}/metodepembayaran', [CheckoutController::class, 'storePayment'])
    ->name('pengguna.metodepembayaran.store')
    ->middleware('auth');

Route::post('/checkout/{product}/store', [CheckoutController::class, 'store'])
    ->name('pengguna.cekout.store')
    ->middleware('auth');

Route::get('/admin/management', [ManagementController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('admin.management');

Route::get('/admin/verifikasi', [AdminStoreController::class, 'index'])
    ->name('admin.verifikasi');

Route::post('/admin/verifikasi/{id}/approve', [AdminStoreController::class, 'approve'])
    ->name('admin.store.approve');

Route::post('/admin/verifikasi/{id}/reject', [AdminStoreController::class, 'reject'])
    ->name('admin.store.reject');




require __DIR__.'/auth.php';
