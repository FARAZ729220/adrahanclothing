<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| FRONTEND ROUTES (TEMPORARILY DISABLED)
|--------------------------------------------------------------------------
*/

// Route::get('/categories', [StorefrontController::class, 'categories']);
// Route::get('/products', [StorefrontController::class, 'products']);
// Route::get('/category/{categoryId}/products', [StorefrontController::class, 'productsByCategory']);
// Route::get('/product/{slug}', [StorefrontController::class, 'productDetail']);

// Route::get('/cart', [CartController::class, 'get']);
// Route::post('/cart/add', [CartController::class, 'add']);
// Route::post('/cart/update', [CartController::class, 'update']);
// Route::post('/cart/remove', [CartController::class, 'remove']);

// Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder']);

// Route::get('/shop', function () {
//     return view('shop');
// });

/*
|--------------------------------------------------------------------------
| ADMIN AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

/*
|--------------------------------------------------------------------------
| ADMIN PANEL ROUTES (Backend Focus)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminAuthController::class, 'admin_dashboard'])
        ->name('admin.dashboard');

    /*
    |--------------------------------------------------------------------------
    | CATEGORY MANAGEMENT
    |--------------------------------------------------------------------------
    */

    Route::post('/categories', [AdminCategoryController::class, 'category_store'])->name('category.store');
    Route::put('/categories/{id}', [AdminCategoryController::class, 'category_update'])->name('category.update');
    Route::delete('/categories/{id}', [AdminCategoryController::class, 'category_destroy'])->name('category.destroy');

    /*
    |--------------------------------------------------------------------------
    | Product MANAGEMENT
    |--------------------------------------------------------------------------
    */

    // Product Management

    Route::get('/products/create', [AdminProductController::class, 'product_create'])->name('product.create');
    Route::post('/products', [AdminProductController::class, 'product_store'])->name('product.store');
    Route::get('/products/{id}/edit', [AdminProductController::class, 'edit'])->name('product.edit');
    Route::put('/products/{id}', [AdminProductController::class, 'update'])->name('product.update');
    Route::delete('/products/{id}', [AdminProductController::class, 'product_destroy'])
        ->name('product.destroy');

    /*
    |--------------------------------------------------------------------------
    | ORDER MANAGEMENT
    |--------------------------------------------------------------------------
    */

    Route::get('/orders', [AdminOrderController::class, 'list']);
    Route::get('/orders/{id}', [AdminOrderController::class, 'detail']);
    Route::post('/orders/{id}/payment-status', [AdminOrderController::class, 'updatePaymentStatus']);
    Route::post('/orders/{id}/mark-delivered', [AdminOrderController::class, 'markDelivered']);

});

/*
|--------------------------------------------------------------------------
| DEFAULT ROUTE
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});
