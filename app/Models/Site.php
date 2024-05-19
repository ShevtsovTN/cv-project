<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int id
 * @property mixed name
 * @property mixed url
 * @property mixed provider_key
 * @property mixed created_at
 * @property mixed updated_at
 */
class Site extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'url',
        'provider_key',
    ];

    public function providers(): BelongsToMany
    {
        return $this->belongsToMany(Provider::class, 'provider_site')
            ->withPivot('active', 'external_id')
            ->withTimestamps();
    }

    public function statistics(): HasMany
    {
        return $this->hasMany(Statistic::class);
    }
}
