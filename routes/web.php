<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminController;

Route::get('/', [ProductController::class, 'index']);
Route::get('/search', [ProductController::class, 'search'])->name('search');
Route::get('/kategori/{slug}', [ProductController::class, 'category'])->name('kategori');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add')->middleware('auth');
Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy')->middleware('auth');

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index')->middleware('auth');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store')->middleware('auth');

// Orders
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index')->middleware('auth');
Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show')->middleware('auth');
Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel')->middleware('auth');

// Payments
Route::post('/orders/{orderId}/payment', [PaymentController::class, 'store'])->name('payments.store')->middleware('auth');
Route::post('/admin/payments/{id}/approve', [PaymentController::class, 'approve'])->name('payments.approve')->middleware('auth');
Route::post('/admin/payments/{id}/reject', [PaymentController::class, 'reject'])->name('payments.reject')->middleware('auth');

// Reviews
Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store')->middleware('auth');

// Auth
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// User / Seller
Route::get('/user', function () {
    return view('profile.user');
})->middleware('auth');

Route::post('/user/request-seller', [UserController::class, 'requestSeller'])->name('user.request_seller')->middleware('auth');

Route::get('/seller/dashboard', function () {
    return view('seller.products');
});

Route::get('/seller/{id?}', function () {
    return view('profile.seller');
});

// Chat (placeholder view)
Route::get('/chat', function () {
    return view('chat.index');
});

// Admin
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware('auth');

Route::resource('admin/users', UserController::class)->names('users');
Route::post('/admin/users/{user}/approve-seller', [UserController::class, 'approveSeller'])->name('users.approve_seller');