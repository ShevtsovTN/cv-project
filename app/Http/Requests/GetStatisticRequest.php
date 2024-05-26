<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

/**
 * @property string $dateFrom
 * @property string $dateTo
 * @property string $direction
 * @property string $sortBy
 * @property int $perPage
 * @property int $page
 *
 * @OA\Schema(
 *     schema="GetStatisticRequest",
 *     @OA\Property(
 *         property="dateFrom",
 *         type="string",
 *         format="date",
 *         description="Start date for the statistics in YYYY-MM-DD format",
 *         example="2023-01-01"
 *     ),
 *     @OA\Property(
 *         property="dateTo",
 *         type="string",
 *         format="date",
 *         description="End date for the statistics in YYYY-MM-DD format",
 *         example="2023-01-31"
 *     ),
 *     @OA\Property(
 *         property="direction",
 *         type="string",
 *         enum={"asc", "desc"},
 *         description="Sort direction",
 *         example="asc"
 *     ),
 *     @OA\Property(
 *         property="sortBy",
 *         type="string",
 *         enum={"impressions", "revenue"},
 *         description="Field to sort by",
 *         example="impressions"
 *     ),
 *     @OA\Property(
 *         property="perPage",
 *         type="integer",
 *         description="Number of items per page",
 *         example=10,
 *         minimum=1,
 *         maximum=100
 *     ),
 *     @OA\Property(
 *         property="page",
 *         type="integer",
 *         description="Page number",
 *         example=1,
 *         minimum=1
 *     )
 * )
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
