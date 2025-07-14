<?php

namespace App\Models;

use App\Enums\CardTypesEnum;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
        'user_id',
        'card_number',
        'expiry_date',
        'default',
        'type',
        'cardholder_name',
        'code',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'default' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shortNumber(): string
    {
        return substr($this->card_number, -4);
    }

    public function hiddenCardNumber()
    {
        return "•••• •••• •••• {$this->shortNumber()}";
    }

    public function getCardCssClasses(): string
    {
        return CardTypesEnum::from($this->type)->getCssClasses();
    }
}
