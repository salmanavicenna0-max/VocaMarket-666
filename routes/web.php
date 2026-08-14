<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show']);
Route::get('/keranjang', function () {
    return view('cart.index');
});

Route::get('/seller/{id?}', function () {
    return view('profile.seller');
});

Route::get('/chat', function () {
    return view('chat.index');
});

Route::get('/checkout', function () {
    return view('checkout.index');
});
