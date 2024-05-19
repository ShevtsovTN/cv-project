<?php

namespace App\StatisticEntities\ExampleOne;

use App\Interfaces\ProviderRepositoryInterface;
use App\StatisticEntities\BaseProviderConfig;
use Illuminate\Support\Collection;

class ProviderOneConfig extends BaseProviderConfig
{
    public string $url;

    public string $token;

    public function __construct(
        public ProviderRepositoryInterface $providerRepository,
        public string $techName = 'ProviderOne'
    )
    {
        parent::__construct($providerRepository, $techName);
    }
}
