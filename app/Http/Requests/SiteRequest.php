<?php

namespace App\Http\Requests;

use App\Enums\PaginationEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenApi\Annotations as OA;

/**
 * @property string $search
 * @property string $sortBy
 * @property string $direction
 * @property int $page
 * @property int $perPage
 *
 * @OA\Schema(
 *     schema="SiteRequest",
 *     @OA\Property(
 *         property="search",
 *         type="string",
 *         description="Search term",
 *         example="example",
 *         minLength=3,
 *         maxLength=10
 *     ),
 *     @OA\Property(
 *         property="sortBy",
 *         type="string",
 *         enum={"id", "name", "url", "provider_key"},
 *         description="Field to sort by",
 *         example="name"
 *     ),
 *     @OA\Property(
 *         property="direction",
 *         type="string",
 *         enum={"asc", "desc"},
 *         description="Sort direction",
 *         example="asc"
 *     ),
 *     @OA\Property(
 *         property="page",
 *         type="integer",
 *         description="Page number",
 *         example=1,
 *         minimum=1
 *     ),
 *     @OA\Property(
 *         property="perPage",
 *         type="integer",
 *         description="Number of items per page",
 *         example=10,
 *         minimum=1,
 *         maximum=100
 *     )
 * )
 */
class SiteRequest extends FormRequest
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
            'sortBy' => [
                'sometimes',
                'string',
                'in:id,name,url,provider_key',
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
            'perPage' => [
                'sometimes',
                'integer',
                Rule::enum(PaginationEnum::class)
            ],
        ];
    }
}
