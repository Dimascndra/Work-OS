<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DomainMonitor extends Model
{
    protected $guarded = ['id'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'ssl_expires_at' => 'datetime',
            'domain_expires_at' => 'datetime',
            'last_checked_at' => 'datetime',
        ];
    }
}
