<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SshKey extends Model
{
    protected $fillable = [
        'ip_server',
        'username',
        'password',
        'port',
        'public_key',
    ];
}
