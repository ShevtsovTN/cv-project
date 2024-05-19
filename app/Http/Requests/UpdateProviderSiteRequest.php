<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenApi\Annotations as OA;

class UpdateProviderSiteRequest extends FormRequest
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
            'active' => 'sometimes|boolean',
            'external_id' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('provider_site', 'external_id')
                    ->where('site_id', $this->route('site'))
                    ->where('provider_id', $this->route('provider'))
            ],
        ];
    }
}
