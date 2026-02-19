<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSnippetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'code_content' => 'required|string',
            'language' => 'required|string',
            'tags' => 'nullable|string',
        ];
    }
}
