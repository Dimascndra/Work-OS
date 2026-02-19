<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scratchpad extends Model
{
    protected $fillable = ['user_id', 'content', 'title', 'color', 'position'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
