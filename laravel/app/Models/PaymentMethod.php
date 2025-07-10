<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $casts = [
        'expiry_date' => 'date',
    ];
}
