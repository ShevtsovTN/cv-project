<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @property int id
 * @property string name
 * @property boolean active
 * @property string created_at
 * @property string updated_at
 *
 * @OA\Schema(
 *     schema="ProviderResource",
 *      type="object",
 *      title="Provider Resource",
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          description="ID of the provider"
 *      ),
 *      @OA\Property(
 *          property="name",
 *          type="string",
 *          description="Name of the provider"
 *      ),
 *      @OA\Property(
 *          property="active",
 *          type="boolean",
 *          description="Active status of the provider"
 *      ),
 *      @OA\Property(
 *          property="created_at",
 *          type="string",
 *          format="date-time",
 *          description="Creation timestamp"
 *      ),
 *      @OA\Property(
 *          property="updated_at",
 *          type="string",
 *          format="date-time",
 *          description="Last update timestamp"
 *      )
 * )
 */
class ProviderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'active' => $this->active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
