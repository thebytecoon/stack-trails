<?php

namespace App\Enums;

enum CartDisplayEnum: string
{
    case OFFCANVAS = 'offcanvas';
    case PAGE = 'page';

    public function getView(): string
    {
        return match ($this) {
            self::OFFCANVAS => 'carts.offcanvas_htmx',
            self::PAGE => 'carts.cart_page',
        };
    }
}
