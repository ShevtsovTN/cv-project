<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $dateFrom
 * @property string $dateTo
 * @property string $direction
 * @property string $sortBy
 * @property int $perPage
 * @property int $page
 */
class GetStatisticRequest extends FormRequest
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
            'dateFrom' => 'sometimes|date:Y-m-d',
            'dateTo' => 'sometimes|date:Y-m-d',
            'direction' => 'sometimes|in:asc,desc',
            'sortBy' => 'sometimes|in:impressions,revenue',
            'perPage' => 'sometimes|integer|min:1|max:100',
            'page' => 'sometimes|integer|min:1',
        ];
    }
}
