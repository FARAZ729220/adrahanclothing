<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StorefrontController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminAuthController;



Route::get('/categories', [StorefrontController::class, 'categories']);
Route::get('/products', [StorefrontController::class, 'products']);
Route::get('/category/{categoryId}/products', [StorefrontController::class, 'productsByCategory']);
Route::get('/product/{slug}', [StorefrontController::class, 'productDetail']);

Route::get('/cart', [CartController::class, 'get']);
Route::post('/cart/add', [CartController::class, 'add']);
Route::post('/cart/update', [CartController::class, 'update']);
Route::post('/cart/remove', [CartController::class, 'remove']);

Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder']);

// Admin (later protect with auth)
Route::get('/admin/orders', [AdminOrderController::class, 'list']);
Route::get('/admin/orders/{id}', [AdminOrderController::class, 'detail']);
Route::post('/admin/orders/{id}/payment-status', [AdminOrderController::class, 'updatePaymentStatus']);
Route::post('/admin/orders/{id}/mark-delivered', [AdminOrderController::class, 'markDelivered']);


// Admin routes
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/categories', [AdminCategoryController::class, 'index']);
    Route::post('/categories', [AdminCategoryController::class, 'store']);
    Route::get('/categories/{id}', [AdminCategoryController::class, 'show']);
    Route::put('/categories/{id}', [AdminCategoryController::class, 'update']);
    Route::delete('/categories/{id}', [AdminCategoryController::class, 'destroy']);
});


Route::get('/', function () {
    return view('welcome');
});


Route::get('/shop', function () {
    return view('shop');
});
