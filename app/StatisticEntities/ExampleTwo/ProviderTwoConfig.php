<?php

namespace App\StatisticEntities\ExampleTwo;

use App\Interfaces\ProviderRepositoryInterface;
use App\StatisticEntities\BaseProviderConfig;

class ProviderTwoConfig extends BaseProviderConfig
{
    public string $url;

    public string $email;

    public string $password;

    public function __construct(
        public ProviderRepositoryInterface $providerRepository,
        public string $techName = 'ProviderTwo'
    )
    {
        parent::__construct($providerRepository, $techName);
    }
}
