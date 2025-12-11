<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Store\StoreController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Seller\SellerDashboardController;
use App\Http\Controllers\Store\ProductCategoryController;
use App\Http\Controllers\Seller\OrderController;
use App\Http\Controllers\Seller\CategoryController;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Verifikasi Toko
    Route::get('/store-verification', [AdminController::class, 'storeVerification'])->name('store.verification');
    Route::post('/store/{id}/approve', [AdminController::class, 'approveStore'])->name('store.approve');
    Route::delete('/store/{id}/reject', [AdminController::class, 'rejectStore'])->name('store.reject');
    
    // Manajemen User
    Route::get('/users', [AdminController::class, 'userManagement'])->name('users');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');
    
    // Manajemen Toko
    Route::get('/stores', [AdminController::class, 'storeManagement'])->name('stores');
    Route::delete('/stores/{id}', [AdminController::class, 'deleteStore'])->name('stores.delete');
    Route::post('/stores/{id}/toggle', [AdminController::class, 'toggleStoreVerification'])->name('stores.toggle');
});

// Homepage
Route::get('/', [HomeController::class, 'index']);

// Category
Route::get('/category/{slug}', [ProductCategoryController::class, 'show'])->name('category.show');

// Product Detail
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/category/{slug}', [ProductController::class, 'byCategory'])->name('products.by-category');
Route::get('/products/{id}', [ProductController::class, 'detail'])->name('products.detail');

// Checkout + Transaction (auth)
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

    Route::get('/transactions', [TransactionController::class, 'index'])->name('transaction.index');
    Route::get('/transaction/{id}', [TransactionController::class, 'show'])->name('transaction.show');
    Route::get('/transaction/{id}/success', [TransactionController::class, 'success'])->name('transaction.success');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    }
);
Route::get('/profile', function () {
    return view('profile'); // buat halaman ini nanti
})->name('profile')->middleware('auth');

// tambah keranjang : 
Route::post('/cart/add/{id}', function() {
    return back()->with('success', 'Produk ditambahkan ke keranjang (dummy)');
})->name('cart.add');

// tambahan fitur :
Route::get('/', [HomeController::class, 'index'])->name('home');

// tambah fitur untuk Seller
Route::prefix('seller')->name('seller.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', function () {
        return view('seller.dashboard');
    })->name('dashboard');

    // Registrasi Toko
    Route::get('/register', function () {
        return view('seller.register');
    })->name('register');

    // Manajemen Produk
    Route::get('/products', function () {
        return view('seller.products.index');
    })->name('products.index');

    // Route::resource('categories', App\Http\Controllers\Seller\CategoryController::class);

});


Route::post('/cart/add/{id}', function() {
    return back()->with('success', 'Produk ditambahkan ke keranjang (dummy)');
})->name('cart.add');


// Routes untuk Store (Seller)
Route::middleware('auth')->prefix('store')->name('store.')->group(function () {
    // Registrasi Toko
    Route::get('/create', [StoreController::class, 'create'])->name('create');
    Route::post('/create', [StoreController::class, 'store'])->name('store');
    
    // Dashboard & Management
    Route::get('/dashboard', [StoreController::class, 'dashboard'])->name('dashboard');
    Route::get('/pending', [StoreController::class, 'pending'])->name('pending');
    Route::get('/edit', [StoreController::class, 'edit'])->name('edit');
    Route::put('/update', [StoreController::class, 'update'])->name('update');
});

require __DIR__.'/auth.php';

