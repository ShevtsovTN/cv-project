<?php

namespace App\StatisticEntities\ExampleOne;

use App\StatisticEntities\BaseProvider;

class ProviderOne extends BaseProvider
{
    public function __construct(ProviderOneConfig $config, ProviderOneCollection $statistic)
    {
        parent::__construct($config, $statistic);
    }
}
