<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenApi\Annotations as OA;


/**
 * @OA\Schema(
 *     schema="UpdateProviderSiteRequest",
 *     @OA\Property(
 *         property="active",
 *         type="boolean",
 *         description="Whether the provider site is active",
 *         example=true
 *     ),
 *     @OA\Property(
 *         property="external_id",
 *         type="string",
 *         description="The external ID of the provider site",
 *         example="external123",
 *         maxLength=255
 *     )
 * )
 */
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
