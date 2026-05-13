<?php

namespace App\Services;

use App\Models\Credential;
use Illuminate\Database\Eloquent\Collection;

class CredentialService
{
    public function getAll(): Collection
    {
        return Credential::latest()->get();
    }

    public function create(array $data): Credential
    {
        return Credential::create($data);
    }

    public function update(Credential $credential, array $data): Credential
    {
        if (empty($data['password'])) {
            unset($data['password']);
        }

        $credential->update($data);
        return $credential->refresh();
    }

    public function delete(Credential $credential): bool
    {
        return $credential->delete();
    }
}
