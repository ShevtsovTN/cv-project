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
 * @property bool active
 * @property string created_at
 * @property string updated_at
 * @property string tech_name
 * @property-read Collection<Site> sites
 * @property-read Collection<Statistic> statistics
 * @property-read mixed $pivot
 */
class Provider extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tech_name',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function sites(): BelongsToMany
    {
        return $this->belongsToMany(Site::class, 'provider_site')
            ->withPivot('active', 'external_id')
            ->withTimestamps();
    }

    public function statistics(): HasMany
    {
        return $this->hasMany(Statistic::class);
    }
}
