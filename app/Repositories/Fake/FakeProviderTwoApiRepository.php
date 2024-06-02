<?php

namespace App\Repositories\Fake;

use App\Helpers\DatetimeHelper;
use App\Interfaces\ApiRepositoryStatisticInterface;
use App\Interfaces\Example\ProviderInterface;
use Illuminate\Support\Collection;
use Random\RandomException;

class FakeProviderTwoApiRepository implements ApiRepositoryStatisticInterface
{

    /**
     * @throws RandomException
     */
    public function getStatistics(ProviderInterface $provider, DatetimeHelper $datetimeHelper): Collection
    {
        $fakeResultCollection = collect();
        $sites = $provider->getActiveSites();

        foreach ($sites as $activeSite) {
            $fakeResultCollection->push([
                'Id' => $activeSite->external_id,
                'DateTime' => $datetimeHelper->getRandomDate()->format('Y-m-d H:i:s'),
                'Imp' => random_int(1, 10000),
                'Rev' => random_int(10, 100) * 0.1,
            ]);
        }

        return $provider
            ->getStatisticInstance()
            ->prepareData(
                $fakeResultCollection,
                $provider,
                $sites
            );
    }
}
