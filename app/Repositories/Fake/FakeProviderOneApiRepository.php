<?php

namespace App\Repositories\Fake;

use App\Helpers\DatetimeHelper;
use App\Interfaces\ApiRepositoryStatisticInterface;
use App\Interfaces\Example\ProviderInterface;
use Illuminate\Support\Collection;
use Throwable;

class FakeProviderOneApiRepository implements ApiRepositoryStatisticInterface
{

    /**
     * @param ProviderInterface $provider
     * @param DatetimeHelper $datetimeHelper
     * @return Collection
     * @throws Throwable
     */
    public function getStatistics(ProviderInterface $provider, DatetimeHelper $datetimeHelper): Collection
    {
        $fakeResult = collect();
        $sites = $provider->getActiveSites();

        foreach ($sites as $activeSite) {
            $fakeResult->push([
                $activeSite->external_id => [
                    'Date' => $datetimeHelper->getRandomDate()->format('Y-m-d'),
                    'SiteImpressions' => random_int(1, 10000),
                    'SiteRevenue' => random_int(10, 100) * 0.1,
                ]
            ]);
        }

        $fakeResultCollection = $fakeResult->map(function ($responseData) {
                $firstKey = array_key_first($responseData);
                $responseData[$firstKey]['SiteID'] = $firstKey;
                return $responseData[$firstKey];
            });

        return $provider
            ->getStatisticInstance()
            ->prepareData(
                $fakeResultCollection,
                $provider,
                $sites
            );
    }
}
