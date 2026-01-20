<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'ip_address' => 'required|string',
            'port' => 'required|integer',
            'username' => 'required|string',
            'password' => 'nullable|string',
            'private_key' => 'nullable|string',
            'public_key' => 'nullable|string',
            'os_type' => 'required|string',
            'server_type' => 'required|in:Physical,VPS,Cloud,Container,Other',
            'is_active' => 'boolean',
            'description' => 'nullable|string',
        ];
    }
}
