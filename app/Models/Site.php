<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property int id
 * @property string name
 * @property string url
 * @property string provider_key
 * @property string created_at
 * @property string updated_at
 * @property-read Collection<Provider> providers
 * @@property-read Collection<Statistic> statistics
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
