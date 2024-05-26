<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

/**
 * @property string $name
 * @property string $url
 * @property string $provider_key
 *
 * @OA\Schema(
 *     schema="StoreSiteRequest",
 *     required={"name", "url", "provider_key"},
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The name of the site",
 *         example="Example Site",
 *         maxLength=255,
 *         minLength=1
 *     ),
 *     @OA\Property(
 *         property="url",
 *         type="string",
 *         description="The URL of the site",
 *         example="https://www.example.com",
 *         maxLength=255
 *     ),
 *     @OA\Property(
 *         property="provider_key",
 *         type="string",
 *         description="The provider key for the site",
 *         example="example_provider_key",
 *         maxLength=255
 *     )
 * )
 */
class StoreSiteRequest extends FormRequest
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
            'name' => 'required|string|max:255|min:1',
            'url' => 'required|string|max:255|unique:sites,url',
            'provider_key' => 'required|string|max:255|unique:sites,provider_key',
        ];
    }
}
