<?php

namespace App\Models;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Credential extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::creating(function ($credential) {
            $credential->user_id = auth()->id();
        });

        static::addGlobalScope('user', function (\Illuminate\Database\Eloquent\Builder $builder) {
            if (auth()->check()) {
                $builder->where('user_id', auth()->id());
            }
        });
    }

    public function getPasswordAttribute(?string $value): ?string
    {
        return $this->decryptCredentialValue($value);
    }

    public function setPasswordAttribute(?string $value): void
    {
        $this->attributes['password'] = $this->encryptCredentialValue($value);
    }

    public function getNotesAttribute(?string $value): ?string
    {
        return $this->decryptCredentialValue($value);
    }

    public function setNotesAttribute(?string $value): void
    {
        $this->attributes['notes'] = $this->encryptCredentialValue($value);
    }

    public function passwordIsDecryptable(): bool
    {
        return $this->encryptedAttributeIsDecryptable('password');
    }

    public function notesIsDecryptable(): bool
    {
        return $this->encryptedAttributeIsDecryptable('notes');
    }

    private function decryptCredentialValue(?string $value): ?string
    {
        if ($value === null || $value === '') {
            return $value;
        }

        try {
            return Crypt::decryptString($value);
        } catch (DecryptException) {
            return null;
        }
    }

    private function encryptCredentialValue(?string $value): ?string
    {
        if ($value === null || $value === '') {
            return $value;
        }

        return Crypt::encryptString($value);
    }

    private function encryptedAttributeIsDecryptable(string $key): bool
    {
        $value = $this->getRawOriginal($key) ?? $this->attributes[$key] ?? null;

        if ($value === null || $value === '') {
            return true;
        }

        try {
            Crypt::decryptString($value);

            return true;
        } catch (DecryptException) {
            return false;
        }
    }
}
