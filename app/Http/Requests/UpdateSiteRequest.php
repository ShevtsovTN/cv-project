<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="UpdateSiteRequest",
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The name of the site",
 *         example="Updated Site Name",
 *         maxLength=255
 *     ),
 *     @OA\Property(
 *         property="url",
 *         type="string",
 *         description="The URL of the site",
 *         example="https://www.updated-example.com",
 *         maxLength=2048
 *     ),
 *     @OA\Property(
 *         property="provider_key",
 *         type="string",
 *         description="The provider key for the site",
 *         example="updated_provider_key",
 *         maxLength=255
 *     )
 * )
 */
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
