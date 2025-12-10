<?php

use App\Http\Controllers\ProfileController;

use App\Http\Controllers\AdminController;

use App\Http\Controllers\ProductController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Fitur search dropdown
// Route::get('/products/search', [ProductController::class, 'search'])
//     ->name('products.search');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
   Route::get('/register/store', [ProfileController::class, 'storeRegisterForm'])->name('store.register.form');
    Route::post('/register/store', [ProfileController::class, 'storeRegisterSubmit'])->name('store.register.submit');
    
    // Rute untuk Buyer (Form Registrasi Profil Buyer)
    // KOREKSI GET: Ubah 'showBuyerForm' menjadi 'buyerRegisterForm'
    Route::get('/register/buyer', [ProfileController::class, 'buyerRegisterForm'])->name('buyer.register.form'); 
    
    // KOREKSI POST: Ubah 'storeBuyerData' menjadi 'buyerRegisterSubmit'
    Route::post('/register/buyer', [ProfileController::class, 'buyerRegisterSubmit'])->name('buyer.register.submit');

});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    
    Route::get('/stores/verification', [AdminController::class, 'storeVerification'])->name('admin.stores.verification');
    Route::post('/stores/{store}/verify', [AdminController::class, 'verifyStore'])->name('admin.stores.verify');
    Route::post('/stores/{store}/reject', [AdminController::class, 'rejectStore'])->name('admin.stores.reject'); // Opsional

    Route::get('/users-stores', [AdminController::class, 'userAndStoreManagement'])->name('admin.users-stores.index');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update'); // Menggunakan PUT untuk UPDATE
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy'); // Menggunakan DELETE untuk HAPUS
});

require __DIR__.'/auth.php';
