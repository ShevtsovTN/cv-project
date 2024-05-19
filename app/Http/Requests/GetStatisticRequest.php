<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

/**
 * @property string $dateFrom
 * @property string $dateTo
 * @property string $direction
 * @property string $sortBy
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

    #[
        OA\Schema(
            schema: 'GetStatisticRequest',
            type: 'object',
            properties: [
                new OA\Property(
                    property: 'dateFrom',
                    type: 'string',
                    format: 'date',
                    description: 'The start date for the statistics',
                    example: '2023-01-01'
                ),
                new OA\Property(
                    property: 'dateTo',
                    type: 'string',
                    format: 'date',
                    description: 'The end date for the statistics',
                    example: '2023-01-31'
                ),
                new OA\Property(
                    property: 'direction',
                    type: 'string',
                    description: 'The direction of sorting',
                    enum: ['asc', 'desc'],
                    example: 'asc'
                ),
                new OA\Property(
                    property: 'sortBy',
                    type: 'string',
                    description: 'The field to sort by',
                    enum: ['impressions', 'revenue'],
                    example: 'revenue'
                ),
            ],
            required: ['dateFrom', 'dateTo', 'direction', 'sortBy']
        )
    ]
    public function rules(): array
    {
        return [
            'dateFrom' => 'required|date:Y-m-d',
            'dateTo' => 'required|date:Y-m-d',
            'direction' => 'required|in:asc,desc',
            'sortBy' => 'required|in:impressions,revenue',
        ];
    }
}
