<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/dashboard', function () {
    return view('Admin.Dashboard');
});

Route::get('/login', function () {
    return view('auth.login');
});
