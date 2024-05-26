<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @property int id
 * @property int provider_id
 * @property string collected_at
 * @property string collected_date
 * @property int site_id
 * @property int impressions
 * @property float revenue
 * @property string created_at
 * @property string updated_at
 *
 * @OA\Schema(
 *      schema="StatisticResource",
 *      type="object",
 *      title="Statistic Resource",
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          description="ID of the statistic"
 *      ),
 *      @OA\Property(
 *          property="provider_id",
 *          type="integer",
 *          description="ID of the provider"
 *      ),
 *      @OA\Property(
 *          property="collected_at",
 *          type="string",
 *          format="date-time",
 *          description="Timestamp when the data was collected"
 *      ),
 *      @OA\Property(
 *          property="collected_date",
 *          type="string",
 *          description="Date when the data was collected"
 *      ),
 *      @OA\Property(
 *          property="site_id",
 *          type="integer",
 *          description="ID of the site"
 *      ),
 *      @OA\Property(
 *          property="impressions",
 *          type="integer",
 *          description="Number of impressions"
 *      ),
 *      @OA\Property(
 *          property="revenue",
 *          type="number",
 *          format="float",
 *          description="Revenue generated"
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
class StatisticResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'provider_id' => $this->provider_id,
            'collected_at' => $this->collected_at,
            'collected_date' => $this->collected_date,
            'site_id' => $this->site_id,
            'impressions' => $this->impressions,
            'revenue' => $this->revenue,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
