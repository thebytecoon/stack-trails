<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProductSearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('products/search', ProductSearchController::class)
    ->name('api.products.search');
Route::resource('products', ProductsController::class);
