<?php

namespace App\Services;

use App\Models\Server;
use Illuminate\Database\Eloquent\Collection;

class ServerService
{
    /**
     * Get all servers.
     */
    public function getAll(): Collection
    {
        return Server::latest()->get();
    }

    /**
     * Create a new server.
     */
    public function create(array $data): Server
    {
        // Handle boolean
        $data['is_active'] = isset($data['is_active']) ? (bool) $data['is_active'] : false;

        return Server::create($data);
    }

    /**
     * Update a server.
     */
    public function update(Server $server, array $data): Server
    {
        // Handle boolean
        $data['is_active'] = isset($data['is_active']) ? (bool) $data['is_active'] : false;

        // If password field is empty, don't update it
        if (empty($data['password'])) {
            unset($data['password']);
        }

        $server->update($data);
        return $server->refresh();
    }

    /**
     * Delete a server.
     */
    public function delete(Server $server): bool
    {
        return $server->delete();
    }
}
