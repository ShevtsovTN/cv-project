<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

/**
 * @property string $name
 * @property bool $active
 */
class StoreProviderRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:providers,name',
            'tech_name' => 'required|string|max:255|unique:providers,tech_name',
            'active' => 'required|boolean',
        ];
    }
}
