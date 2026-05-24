<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('products.show');

// Cart routes
Route::get('/cart', [OrderController::class, 'cart'])->name('cart');
Route::post('/cart/add/{productId}', [OrderController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [OrderController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove/{productId}', [OrderController::class, 'removeFromCart'])->name('cart.remove');

// NEW: Update cart with customer information
Route::post('/cart/update-with-info', [OrderController::class, 'updateCartWithInfo'])->name('cart.update.with.info');
Route::get('/cart/summary', [OrderController::class, 'getCartSummary'])->name('cart.summary');

// Customer info routes
Route::post('/cart/save-customer', [OrderController::class, 'saveCustomerInfo'])->name('cart.save.customer');
Route::post('/cart/save-and-checkout', [OrderController::class, 'saveAndCheckout'])->name('cart.save.and.checkout');

// Checkout and Orders
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/order/place', [OrderController::class, 'placeOrder'])->name('order.place');
    Route::get('/order/receipt/{order}', [OrderController::class, 'receipt'])->name('orders.receipt');
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('my-orders');
});

// Admin routes
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/admin/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/admin/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/admin/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/admin/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/admin/orders', [OrderController::class, 'adminOrders'])->name('admin.orders');
    Route::post('/admin/orders/{order}/status', [OrderController::class, 'updateOrderStatus'])->name('admin.order.status');
});

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');