<?php

namespace App\StatisticEntities\ExampleOne;

use App\Interfaces\Example\ProviderCollectionInterface;
use App\Interfaces\Example\ProviderInterface;
use App\StatisticEntities\BaseExampleCollection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class ProviderOneCollection extends BaseExampleCollection implements ProviderCollectionInterface
{

    public function prepareData(Collection $collection, ProviderInterface $provider, Collection $sites): Collection
    {
        $providerId = $provider->getConfig()->getId();
        return $collection->map(function ($item) use ($providerId, $sites) {
            $site = $sites->firstWhere('external_id', $item['SiteID']);
            return [
                'provider_id' => $providerId,
                'site_id' => $site->id,
                'collected_date' => $item['Date'],
                'impressions' => $item['SiteImpressions'],
                'collected_at' => now()->timestamp,
                'revenue' => $item['SiteRevenue'],
            ];
        });
    }
}
