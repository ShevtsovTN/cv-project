<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

/**
 * @property string $name
 * @property string $tech_name
 * @property bool $active
 *
 * @OA\Schema(
 *     schema="StoreProviderRequest",
 *     required={"name", "tech_name", "active"},
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The name of the provider",
 *         example="Example Provider",
 *         maxLength=255
 *     ),
 *     @OA\Property(
 *         property="tech_name",
 *         type="string",
 *         description="The technical name of the provider",
 *         example="example_provider",
 *         maxLength=255
 *     ),
 *     @OA\Property(
 *         property="active",
 *         type="boolean",
 *         description="Whether the provider is active",
 *         example=true
 *     )
 * )
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
