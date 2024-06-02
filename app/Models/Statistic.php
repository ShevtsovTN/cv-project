<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int id
 * @property int provider_id
 * @property int collected_at
 * @property string collected_date
 * @property int site_id
 * @property int impressions
 * @property float revenue
 * @property string created_at
 * @property string updated_at
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
