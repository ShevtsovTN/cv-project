<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

class UpdateProviderRequest extends FormRequest
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
        $providerId = $this->route('provider');

        return [
            'name' => 'sometimes|string|max:255|unique:providers,name,' . $providerId,
            'active' => 'sometimes|boolean',
        ];
    }
}
