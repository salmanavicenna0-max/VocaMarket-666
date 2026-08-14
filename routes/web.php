<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::resource('user', UserController::class);
Route::middleware('admin')->group(function() {
    Route::resource('user', UserController::class);
});
