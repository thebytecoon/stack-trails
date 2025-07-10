<?php

namespace App\ShoppingCart;

use App\Contracts\CanShop;
use Illuminate\Foundation\Application;

final class Cartfactory
{
    public function __construct(protected Application $app)
    {
    }

    public function getDriver(): CanShop
    {
        if ($this->app['request']->user()) {
            return new DatabaseCart($this->app['request']->user());
        }

        return new SessionCart($this->app['session']);
    }
}
