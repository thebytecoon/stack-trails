<?php

namespace App\Enums;

enum OrderStatusEnum: string
{
    case INITIAL = "initial";
    case PAID = "paid";
    case CANCELLED = "cancelled";

    public function getLabel(): string
    {
        return match ($this) {
            self::INITIAL => "Inicial",
            self::PAID => "Pagada",
            self::CANCELLED => "Cancelada",
        };
    }
}
