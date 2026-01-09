<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    protected $fillable = [
        'name',
        'ip_address',
        'port',
        'username',
        'password',
        'private_key',
        'public_key',
        'os_type',
        'server_type',
        'is_active',
        'description',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'private_key' => 'encrypted',
            'password' => 'encrypted',
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
