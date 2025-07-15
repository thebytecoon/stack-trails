<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'name',
        'names',
        'address_line_1',
        'address_line_2',
        'city',
        'country',
        'postal_code',
        'phone_number',
        'default',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
