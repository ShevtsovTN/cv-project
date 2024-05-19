<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

class UpdateSiteRequest extends FormRequest
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
        $siteId = $this->route('site');
        return [
            'name' => 'sometimes|string|max:255',
            'url' => 'sometimes|string|max:2048|unique:sites,url,' . $siteId,
            'provider_key' => 'sometimes|string|max:255|unique:sites,provider_key,' . $siteId,
        ];
    }
}
