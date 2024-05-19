<?php

namespace App\StatisticEntities\ExampleTwo;

use App\Interfaces\Example\ProviderCollectionInterface;
use App\Interfaces\Example\ProviderInterface;
use App\StatisticEntities\BaseExampleCollection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class ProviderTwoCollection extends BaseExampleCollection implements ProviderCollectionInterface
{

    public function prepareData(Collection $collection, ProviderInterface $provider, Collection $sites): Collection
    {
        $providerId = $provider->getConfig()->getId();
        return $collection->map(function ($item) use ($providerId, $sites) {
            $site = $sites->firstWhere('external_id', $item['Id']);
            return [
                'provider_id' => $providerId,
                'site_id' => $site->id,
                'collected_date' => Carbon::createFromFormat('Y-m-d H:i:s', $item['DateTime'])?->format('Y-m-d'),
                'impressions' => $item['Imp'],
                'collected_at' => now()->timestamp,
                'revenue' => $item['Rev'],
            ];
        });
    }
}
