<?php

namespace App\Services;

use App\Models\Credential;
use Illuminate\Database\Eloquent\Collection;
# use Illuminate\Support\Facades\Crypt; // If encryption needed later, current controller doesn't use it explicitly for display but standard practice usually does. However, sticking to "same as existing".

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
        $credential->update($data);
        return $credential->refresh();
    }

    public function delete(Credential $credential): bool
    {
        return $credential->delete();
    }
}
