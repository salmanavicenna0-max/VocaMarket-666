<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

Route::get('/', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show']);
Route::get('/cart', function () {
    return view('cart.index');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/seller/dashboard', function () {
    return view('seller.products');
});

Route::get('/seller/{id?}', function () {
    return view('profile.seller');
});

Route::get('/user', function () {
    return view('profile.user');
});

Route::get('/chat', function () {
    return view('chat.index');
});

Route::get('/checkout', function () {
    return view('checkout.index');
});

Route::get('/admin/dashboard', function () {
    return view('Admin.Dashboard');
});

Route::resource('admin/users', UserController::class)->names('users');
