<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int id
 * @property mixed name
 * @property mixed active
 * @property mixed created_at
 * @property mixed updated_at
 */
class Provider extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tech_name',
        'active',
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
