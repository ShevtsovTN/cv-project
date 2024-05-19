<?php

namespace App\StatisticEntities;

use App\Interfaces\Example\ProviderCollectionInterface;
use App\Interfaces\Example\ProviderConfigInterface;
use App\Interfaces\Example\ProviderInterface;
use Illuminate\Support\Collection;

class BaseProvider implements ProviderInterface
{
    public function __construct(
        public readonly ProviderConfigInterface $config,
        public ProviderCollectionInterface $statistic
    ) {
    }

    public function getConfig(): ProviderConfigInterface
    {
        return $this->config;
    }

    public function getStatisticInstance(): ProviderCollectionInterface
    {
        return $this->statistic;
    }

    public function setStatistic(ProviderCollectionInterface $collection): void
    {
        $this->statistic = $collection;
    }

    public function getActiveSites(): Collection
    {
        return $this->getConfig()->getProviderRepository()->getSitesForStatistic(
            $this->getConfig()->getId(),
            [
                'active' => true,
            ]
        );
    }
}
