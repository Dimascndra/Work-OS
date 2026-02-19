<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Get all users.
     */
    public function getAll(): Collection
    {
        return User::all();
    }

    /**
     * Create a new user.
     */
    public function create(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        return User::create($data);
    }

    /**
     * Update a user.
     */
    public function update(User $user, array $data): User
    {
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        return $user->refresh();
    }

    /**
     * Delete a user.
     */
    public function delete(User $user): bool
    {
        // Prevent deleting self? Controller handles logic or here?
        // Let's handle generic delete here.
        return $user->delete();
    }
}
