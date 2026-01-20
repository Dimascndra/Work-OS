<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDomainMonitorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'server_id' => 'nullable|exists:servers,id',
            'domain_url' => 'required|url',
            'status' => 'required|in:healthy,down,warning',
        ];
    }
}
