<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellerOrderController;
use App\Http\Controllers\SellerProductController;
use App\Http\Controllers\SellerStoreController;
use App\Http\Controllers\SellerBalanceController;
use App\Http\Controllers\Admin\StoreVerificationController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::get('/', [HomeController::class, 'index'])->name('home');

/*CUSTOMER ROUTES*/
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/transactions', function () {
        return view('customer.transactions');
    })->name('transactions');

    Route::get('/transactions/{id}', function ($id) {
        return view('customer.transaction-detail', compact('id'));
    })->name('transactions.show');

    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

    Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart');
    Route::post('/cart/add/{product}', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{cartItem}', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{cartItem}', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');

    // Checkout routes
    Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/process', [App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{transaction}', [App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');

    // Transactions routes
    Route::get('/transactions', function () {
        $query = \App\Models\Transaction::where('user_id', Auth::id())
            ->with(['transactionDetails.product.productImages', 'store']);

        // Filter by payment status
        if (request('status')) {
            $query->where('payment_status', request('status'));
        }

        $transactions = $query->latest()->paginate(10);

        return view('Transactions', compact('transactions'));
    })->name('transactions.history');

    Route::get('/transactions/{id}', function ($id) {
        $transaction = \App\Models\Transaction::with([
            'transactionDetails.product.productImages',
            'store'
        ])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('TransactionDetail', compact('transaction'));
    })->name('transactions.show');
});

/*SELLER ROUTES - WAITING & REJECTED (Tanpa Verifikasi)*/
Route::middleware(['auth', 'role:seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/waiting-verification', function () {
        return view('seller.waiting-verification');
    })->name('waiting');

    Route::get('/store-rejected', function () {
        return view('seller.store-rejected');
    })->name('rejected');
});

/*SELLER ROUTES - DASHBOARD & FEATURES (Dengan Verifikasi)*/
Route::middleware(['auth', 'role:seller', 'seller.verified'])->prefix('seller')->name('seller.')->group(function () {

    // Dashboard (Manajemen Pesanan)
    Route::get('/dashboard', [SellerOrderController::class, 'index'])->name('dashboard');

    // Balance Management
    Route::get('/balance', [SellerBalanceController::class, 'index'])->name('balance.index');
    Route::get('/balance/withdrawal', [SellerBalanceController::class, 'withdrawalForm'])->name('balance.withdrawal');
    Route::post('/balance/withdrawal', [SellerBalanceController::class, 'processWithdrawal'])->name('balance.withdrawal.process');

    // Order Management
    Route::controller(SellerOrderController::class)->group(function () {
        Route::get('/orders', 'index')->name('orders.index');
        Route::get('/orders/{id}', 'show')->name('orders.show');
        Route::put('/orders/{id}/tracking', 'updateTracking')->name('orders.update-tracking');
        Route::delete('/orders/{id}/tracking', 'removeTracking')->name('orders.remove-tracking');
    });

    // Store Management
    Route::get('/store', [SellerStoreController::class, 'index'])->name('store.index');
    Route::get('/store/edit', [SellerStoreController::class, 'edit'])->name('store.edit');
    Route::put('/store', [SellerStoreController::class, 'update'])->name('store.update');
    Route::delete('/store/logo', [SellerStoreController::class, 'deleteLogo'])->name('store.delete-logo');

    // Product Management
    Route::controller(SellerProductController::class)->prefix('products')->name('products.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');

        // Image management
        Route::delete('/{productId}/images/{imageId}', 'deleteImage')->name('delete-image');
        Route::post('/{productId}/images/{imageId}/thumbnail', 'setThumbnail')->name('set-thumbnail');
    });

    // Category Management
    Route::get('/categories', function () {
        return view('seller.categories.index');
    })->name('categories.index');
});

/*ADMIN ROUTES*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Store Verification Routes
    Route::prefix('stores')->name('stores.')->group(function () {
        Route::get('/verify', [StoreVerificationController::class, 'index'])->name('verify');
        Route::get('/{id}', [StoreVerificationController::class, 'show'])->name('show');
        Route::post('/{id}/approve', [StoreVerificationController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [StoreVerificationController::class, 'reject'])->name('reject');
        Route::post('/{id}/reset', [StoreVerificationController::class, 'reset'])->name('reset');
    });

    // User Management Routes
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\UserManagementController::class, 'index'])->name('index');
        Route::get('/{id}', [App\Http\Controllers\Admin\UserManagementController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [App\Http\Controllers\Admin\UserManagementController::class, 'edit'])->name('edit');
        Route::put('/{id}', [App\Http\Controllers\Admin\UserManagementController::class, 'update'])->name('update');
        Route::delete('/{id}', [App\Http\Controllers\Admin\UserManagementController::class, 'destroy'])->name('destroy');
    });

    // Store Management Routes
    Route::prefix('management/stores')->name('stores.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\StoreManagementController::class, 'index'])->name('index');
        Route::get('/{id}', [App\Http\Controllers\Admin\StoreManagementController::class, 'show'])->name('show');
        Route::post('/{id}/suspend', [App\Http\Controllers\Admin\StoreManagementController::class, 'suspend'])->name('suspend');
        Route::post('/{id}/activate', [App\Http\Controllers\Admin\StoreManagementController::class, 'activate'])->name('activate');
        Route::delete('/{id}', [App\Http\Controllers\Admin\StoreManagementController::class, 'destroy'])->name('destroy');
    });
});

/*PROFILE ROUTES*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});