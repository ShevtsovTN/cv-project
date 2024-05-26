<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @property int id
 * @property string name
 * @property string url
 * @property string provider_key
 * @property string created_at
 * @property string updated_at
 *
 * @OA\Schema(
 *      schema="SiteResource",
 *      type="object",
 *      title="Site Resource",
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          description="ID of the site"
 *      ),
 *      @OA\Property(
 *          property="name",
 *          type="string",
 *          description="Name of the site"
 *      ),
 *      @OA\Property(
 *          property="url",
 *          type="string",
 *          description="URL of the site"
 *      ),
 *      @OA\Property(
 *          property="provider_key",
 *          type="string",
 *          description="Provider key of the site"
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
 *  )
 */
class SiteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'url' => $this->url,
            'provider_key' => $this->provider_key,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
