<?php

namespace App\StatisticEntities\ExampleTwo;

use App\StatisticEntities\BaseProvider;

class ProviderTwo extends BaseProvider
{
    public function __construct(ProviderTwoConfig $config, ProviderTwoCollection $statistic)
    {
        parent::__construct($config, $statistic);
    }
}
