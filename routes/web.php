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
use App\Http\Controllers\SellerDashboardController;
use App\Http\Controllers\SellerOrderController;
use App\Http\Controllers\SellerProfileController;
use App\Http\Controllers\UserProfileController;

Route::get('/', [ProductController::class, 'index']);
Route::get('/search', [ProductController::class, 'search'])->name('search');
Route::get('/kategori/{slug}', [ProductController::class, 'category'])->name('kategori');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add')->middleware('auth');
Route::patch('/cart/{id}/update', [CartController::class, 'update'])->name('cart.update')->middleware('auth');
Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy')->middleware('auth');

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index')->middleware('auth');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store')->middleware('auth');

// Orders
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index')->middleware('auth');
Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show')->middleware('auth');
Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel')->middleware('auth');
Route::post('/orders/{id}/refund', [OrderController::class, 'refund'])->name('orders.refund')->middleware('auth');

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
Route::prefix('user')->middleware('auth')->group(function () {
    Route::get('/', [UserProfileController::class, 'index'])->name('user.profile');
    Route::post('/profile', [UserProfileController::class, 'updateProfile'])->name('user.profile.update');
    Route::post('/photo', [UserProfileController::class, 'updatePhoto'])->name('user.profile.photo');
    Route::post('/password', [UserProfileController::class, 'updatePassword'])->name('user.password.update');
    Route::post('/store', [UserProfileController::class, 'updateStore'])->name('user.store.update');
    Route::post('/request-seller', [UserController::class, 'requestSeller'])->name('user.request_seller');
});

Route::prefix('seller')->middleware('auth')->name('seller.')->group(function () {
    Route::get('/dashboard', [SellerDashboardController::class, 'index'])->name('dashboard');
    Route::post('/product', [SellerDashboardController::class, 'storeProduct'])->name('product.store');
    Route::put('/product/{id}', [SellerDashboardController::class, 'updateProduct'])->name('product.update');
    Route::delete('/product/{id}', [SellerDashboardController::class, 'destroyProduct'])->name('product.destroy');

    Route::post('/order/{id}/status', [SellerOrderController::class, 'updateStatus'])->name('order.status');

    Route::post('/mark-orders-read', [SellerDashboardController::class, 'markOrdersRead'])->name('mark_orders_read');
    Route::post('/mark-reviews-read', [SellerDashboardController::class, 'markReviewsRead'])->name('mark_reviews_read');
});

Route::get('/seller/{id}', [SellerProfileController::class, 'show'])->name('seller.profile');

// Chat (placeholder view)
Route::get('/chat', function () {
    return view('chat.index');
});

// Admin
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/transactions', [AdminController::class, 'transactions'])->name('admin.transactions');
    Route::post('/admin/refund/{id}/approve', [AdminController::class, 'approveRefund'])->name('admin.refund.approve');
    Route::post('/admin/refund/{id}/reject', [AdminController::class, 'rejectRefund'])->name('admin.refund.reject');
    Route::resource('admin/users', UserController::class);
});

Route::post('/admin/users/{user}/approve-seller', [UserController::class, 'approveSeller'])->name('users.approve_seller');
