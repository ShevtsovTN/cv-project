<?php

namespace App\Interfaces\Example;

use Illuminate\Support\Collection;

interface ProviderInterface
{
    public function getConfig(): ProviderConfigInterface;

    public function getStatisticInstance(): ProviderCollectionInterface;

    public function setStatistic(ProviderCollectionInterface $collection): void;

    public function getActiveSites(): Collection;
}
