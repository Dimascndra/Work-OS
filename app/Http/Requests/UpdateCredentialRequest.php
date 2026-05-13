<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCredentialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category' => 'required|string',
            'service_name' => 'required|string',
            'url' => 'nullable|url',
            'username' => 'required|string',
            'password' => 'nullable|string',
            'notes' => 'nullable|string',
        ];
    }
}
