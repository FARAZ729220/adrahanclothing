<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminSettingsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\StorefrontController;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| FRONTEND ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [StorefrontController::class, 'home'])->name('home');
Route::get('/shop', [StorefrontController::class, 'shop'])->name('shop');
Route::get('/contact-us', [StorefrontController::class, 'contact_us'])->name('contact.us');
Route::post('/contact-us', [StorefrontController::class, 'contact_us_store'])->name('contact.us.store');
Route::get('/our-mission-vision', [StorefrontController::class, 'our_mission'])->name('mission');

Route::get('/product/{slug}', [StorefrontController::class, 'productShow'])->name('product.show');

Route::view('/privacy-policy', 'pages.privacy_policy')->name('privacy.policy');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/checkout', [CheckoutController::class, 'showCheckout'])->name('checkout.show');
Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.place');

Route::get('/order-success/{order_number}', [CheckoutController::class, 'success'])
    ->name('checkout.success');

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

Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {

    Route::get('/dashboard', [AdminAuthController::class, 'admin_dashboard'])
        ->name('admin.dashboard');

    /*
    |--------------------------------------------------------------------------
    | CATEGORY MANAGEMENT
    |--------------------------------------------------------------------------
    */

    Route::get('/categories', [AdminCategoryController::class, 'category'])->name('category.index');
    Route::post('/categories', [AdminCategoryController::class, 'category_store'])->name('category.store');
    Route::put('/categories/{id}', [AdminCategoryController::class, 'category_update'])->name('category.update');
    Route::delete('/categories/{id}', [AdminCategoryController::class, 'category_destroy'])->name('category.destroy');

    /*
    |--------------------------------------------------------------------------
    | Product MANAGEMENT
    |--------------------------------------------------------------------------
    */

    // Product Management

    Route::get('/products', [AdminProductController::class, 'product_index'])->name('product.index');
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

    Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');

    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('admin.orders.show');

    Route::post('/orders/{id}/payment-status', [AdminOrderController::class, 'updatePaymentStatus'])
        ->name('admin.orders.paymentStatus');

    Route::post('/orders/{id}/delivery-status', [AdminOrderController::class, 'updateDeliveryStatus'])
        ->name('admin.orders.deliveryStatus');

    Route::post('/orders/{id}/cancel', [AdminOrderController::class, 'cancel'])
        ->name('admin.orders.cancel');

    Route::get('settings', [AdminSettingsController::class, 'setting'])->name('admin.settings');

    Route::post('settings/update', [AdminSettingsController::class, 'setting_update'])->name('admin.settings.update');

    Route::get('/contacts', [AdminAuthController::class, 'admin_contacts'])->name('admin.contacts');
    Route::get('/contacts/{id}', [AdminAuthController::class, 'admin_contacts_details'])->name('admin.contacts.details');
    Route::delete('/contacts/{id}', [AdminAuthController::class, 'admin_contact_delete'])
        ->name('contact.destroy');

    Route::post('/logout', [AdminAuthController::class, 'logout'])
        ->name('admin.logout');

});
