<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSiteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|min:1',
            'url' => 'required|string|max:255|unique:sites,url',
            'provider_key' => 'required|string|max:255|unique:sites,provider_key',
        ];
    }
}
