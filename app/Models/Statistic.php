<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int id
 * @property mixed provider_id
 * @property mixed collected_at
 * @property mixed collected_date
 * @property mixed site_id
 * @property mixed impressions
 * @property mixed revenue
 * @property mixed created_at
 * @property mixed updated_at
 */
class Statistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider_id',
        'collected_at',
        'collected_date',
        'site_id',
        'impressions',
        'revenue',
        'created_at',
        'updated_at'
    ];

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }
}
