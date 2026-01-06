<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServerBackup extends Model
{
    protected $guarded = ['id'];

    public function server()
    {
        return $this->belongsTo(Server::class);
    }
}
