<?php

namespace App\Enums;

enum CardTypesEnum: string
{
    case VISA = 'visa';
    case MASTERCARD = 'master';
    case AMERICAN_EXPRESS = 'amex';
    case DISCOVER = 'discover';
    case DINERS_CLUB = 'diners_club';
    case JCB = 'jcb';

    public function getLabel(): string
    {
        return match ($this) {
            self::VISA => 'Visa',
            self::MASTERCARD => 'MasterCard',
            self::AMERICAN_EXPRESS => 'American Express',
            self::DISCOVER => 'Discover',
            self::DINERS_CLUB => 'Diners Club',
            self::JCB => 'JCB',
        };
    }

    public function getCssClasses(): string
    {
        return match($this) {
            self::VISA => 'from-blue-600 to-blue-700',
            self::MASTERCARD => 'from-red-600 to-red-700',
            self::AMERICAN_EXPRESS => 'from-green-600 to-green-700',
            self::DISCOVER => 'from-yellow-600 to-yellow-700',
            self::DINERS_CLUB => 'from-purple-600 to-purple-700',
            self::JCB => 'from-pink-600 to-pink-700',
            default => 'from-gray-600 to-gray-700',
        };
    }
}
