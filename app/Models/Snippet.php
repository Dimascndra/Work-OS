<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Snippet extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'tags' => 'array',
    ];
}
