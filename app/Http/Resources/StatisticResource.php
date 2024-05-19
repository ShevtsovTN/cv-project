<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
