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
 *     schema="UpdateProviderRequest",
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The name of the provider",
 *         example="Example Provider Name",
 *         maxLength=255,
 *         minLength=5
 *     ),
 *     @OA\Property(
 *         property="active",
 *         type="boolean",
 *         description="The active status of the provider",
 *         example="true",
 *     )
 * )
 */
class UpdateProviderRequest extends FormRequest
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
        $providerId = $this->route('provider');

        return [
            'name' => 'sometimes|string|max:255|min:5|unique:providers,name,' . $providerId,
            'active' => 'sometimes|boolean',
        ];
    }
}
