<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::resource('products', ProductsController::class);