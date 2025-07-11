<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\UserOrdersController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProductSearchController;
use App\Http\Controllers\UserAddressesController;
use App\Http\Controllers\UserPaymentMethodsController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('login', [LoginController::class, 'loginForm'])
    ->name('login');
Route::get('logout', [LoginController::class, 'logout'])
    ->name('logout');
Route::post('login', [LoginController::class, 'postLogin']);
Route::get('products/search', ProductSearchController::class)
    ->name('api.products.search');
Route::resource('products', ProductsController::class);

Route::get('carts', [CartController::class, 'index'])
    ->name('carts.index');

Route::post('carts/add/{product_id}', [CartController::class, 'add'])
    ->name('carts.add');

Route::post('carts/sub/{product_id}', [CartController::class, 'sub'])
    ->name('carts.sub');

Route::delete('carts/{product_id}', [CartController::class, 'destroy'])
    ->name('carts.destroy');

Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'user'], function () {
        Route::resource('orders', UserOrdersController::class)
            ->names('user.orders')
            ->only(['index', 'show']);

        Route::resource('addresses', UserAddressesController::class)
            ->names('user.addresses')
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

        Route::patch('addresses/{id}/set-default', [UserAddressesController::class, 'setDefault'])
            ->name('user.addresses.set_default');

        Route::resource('payment-methods', UserPaymentMethodsController::class)
            ->names('user.payment-methods')
            ->only(['index']);
    });

    Route::group(['prefix' => 'checkout'], function () {
        Route::post('/', CheckoutController::class)
            ->name('checkout.store');

        Route::get('order/{order_id}', OrdersController::class)
            ->name('orders.show');
    });

});
