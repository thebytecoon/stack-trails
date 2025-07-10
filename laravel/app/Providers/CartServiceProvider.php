<?php

namespace App\Providers;

use App\Contracts\CanShop;
use App\ShoppingCart\Cartfactory;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('cart', function ($app) {
            return new CartFactory($app);
        });

        $this->app->singleton('cart.driver', function ($app) {
            return $app['cart']->getDriver();
        });

        $this->app->bind(CanShop::class, function ($app) {
            return $app['cart.driver'];
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('master', function ($view) {
            $carts = app(CanShop::class)->getItems();

            $view->with('carts', $carts);
        });
    }
}
