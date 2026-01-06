<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
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
            'private_key' => 'encrypted',
            'is_active' => 'boolean',
        ];
    }

    public function domainMonitors()
    {
        return $this->hasMany(DomainMonitor::class);
    }

    public function serverBackups()
    {
        return $this->hasMany(ServerBackup::class);
    }
}
