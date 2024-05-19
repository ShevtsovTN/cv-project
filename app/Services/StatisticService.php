<?php

namespace App\Services;

use App\Models\Provider;
use App\Models\Site;
use App\Models\Statistic;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

class StatisticService
{
    public function getAllBySite(Site $site, array $data): Collection
    {
        return $site->statistics()
            ->get();
    }

    public function getAllByProvider(Provider $provider, array $data): Collection
    {
        return $provider->statistics()
            ->get();
    }

    public function saveStatistic(SupportCollection $statisticData): void
    {
        Statistic::query()->upsert(
            $statisticData->toArray(),
            ['collected_date', 'site_id'],
            ['impressions', 'revenue']
        );
    }
}
