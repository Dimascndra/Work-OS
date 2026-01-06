<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'next_billing_date' => 'date',
        'price' => 'decimal:2',
    ];
}
