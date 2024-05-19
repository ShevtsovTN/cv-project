<?php

namespace App\Interfaces\Example;

use Illuminate\Support\Collection;

interface ProviderCollectionInterface
{
    public function prepareData(
        Collection $collection,
        ProviderInterface $provider,
        Collection $sites
    ): Collection;
}
