<?php

namespace App\Repositories;

use App\Helpers\DatetimeHelper;
use App\Http\Middleware\CustomMiddleware\ProviderTwoApiMiddleware;
use App\Http\Middleware\CustomMiddleware\ProviderTwoCredentialsMiddleware;
use App\Interfaces\ApiRepositoryStatisticInterface;
use App\Interfaces\Example\ProviderInterface;
use GuzzleHttp\Promise\Utils;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use RuntimeException;

/**
 * Class ProviderTwoApiRepository
 *
 * @property array $apiEndpoints
 * @method array apiGetAuthSync(array $data = [], array $urlParams = [], array $queryParams = [])
 * @method array apiGetStatisticsSync(array $data = [], array $urlParams = [], array $queryParams = [])
 */
class ProviderTwoApiRepository extends AbstractApiRepository implements ApiRepositoryStatisticInterface
{
    public const API_ENDPOINTS = [

        'apiGetAuthSync' => [
            'endpoint' => '/auth',
            'method' => 'POST',
            'middleware' => [
                ProviderTwoCredentialsMiddleware::class,
            ],

        ],
        'apiGetStatisticsSync' => [
            'endpoint' => '/stat/sites',
            'method' => 'POST',
            'middleware' => [
                ProviderTwoApiMiddleware::class,
            ],
        ],
    ];

    public function getStatistics(ProviderInterface $provider, DatetimeHelper $datetimeHelper): Collection
    {
        $this->setAuth();

        $sites = $provider->getActiveSites();

        [$dateFrom, $dateTo] = $datetimeHelper->getIntervalWithFormat('Y-m-d');

        $response = $this->apiGetStatisticsSync([
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'sites' => implode(',', $sites->pluck('external_id')->toArray()),
        ]);

        if (!empty($response['data'])) {

            $resultCollection = collect($response['data'])
                ->filter(function ($responseData) {
                    return !empty(data_get($responseData, '*'));
                });

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

    private function setAuth(): void
    {
        if (! Cache::has('providerTwoAuthToken')) {
            $response = $this->apiGetAuthSync();
            if (isset($response['token'])) {
                Cache::put('providerTwoAuthToken', $response['token'], 60 * 60 * 24);
            } else {
                throw new RuntimeException('Token is not received from ExampleTwo API.', 400);
            }
        }
    }
}
