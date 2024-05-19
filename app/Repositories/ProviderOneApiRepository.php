<?php

namespace App\Repositories;

use App\Helpers\DatetimeHelper;
use App\Http\Middleware\CustomMiddleware\ProviderOneApiMiddleware;
use App\Interfaces\ApiRepositoryStatisticInterface;
use App\Interfaces\Example\ProviderInterface;
use GuzzleHttp\Promise\Utils;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use RuntimeException;
use Throwable;

/**
 * Class ExampleOneApiRepository
 *
 * @property array $apiEndpoints
 * @method array apiGetSiteStatistics(array $data = [], array $urlParams = [], array $queryParams = [])
 */
class ProviderOneApiRepository extends AbstractApiRepository implements ApiRepositoryStatisticInterface
{
    public const API_ENDPOINTS = [

        'apiGetSiteStatistics' => [
            'endpoint' => '/stat/sites/{id}',
            'method' => 'GET',
            'middleware' => [
                ProviderOneApiMiddleware::class,
            ],
        ],
    ];

    /**
     * @param ProviderInterface $provider
     * @param DatetimeHelper $datetimeHelper
     * @return Collection
     * @throws Throwable
     */
    public function getStatistics(ProviderInterface $provider, DatetimeHelper $datetimeHelper): Collection
    {
        $sites = $provider->getActiveSites();

        $promises = [];

        [$dateFrom, $dateTo] = $datetimeHelper->getIntervalWithFormat('Y-m-d');

        foreach ($sites as $site) {
            $promises[$site->id] = $this->apiGetSiteStatistics(
                [
                    'startDate' => $dateFrom,
                    'endDate' => $dateTo,
                    'dimensions' => 'date',
                    'metrics' => 'impressions,revenue',
                    'timeZone' => $datetimeHelper->tz(),
                ],
                [
                    'id' => $site->external_id,
                ]
            );
        }

        $resultCollection = collect(Utils::unwrap($promises))
            ->filter(function ($responseData) {
                return !empty(data_get($responseData, '*'));
            })->map(function ($responseData) {
                $firstKey = array_key_first($responseData);
                $responseData[$firstKey]['SiteID'] = $firstKey;
                return $responseData[$firstKey];
            });

        if ($resultCollection->isNotEmpty()) {
            return $provider
                ->getStatisticInstance()
                ->prepareData(
                    $resultCollection,
                    $provider,
                    $sites
                );
        }
        throw new RuntimeException('Data from ExampleOne API is empty.', 400);
    }
}
