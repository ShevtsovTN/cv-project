<?php

namespace App\Http\Requests;

use App\Enums\PaginationEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProviderRequest extends FormRequest
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
            'search' => [
                'sometimes',
                'string',
                'min:3',
                'max:10',
            ],
            'sort' => [
                'sometimes',
                'string',
                'in:id,name,active',
            ],
            'direction' => [
                'sometimes',
                'string',
                'in:asc,desc',
            ],
            'page' => [
                'sometimes',
                'integer',
                'min:1',
            ],
            'per_page' => [
                'sometimes',
                'integer',
                Rule::enum(PaginationEnum::class)
            ],
        ];
    }
}
