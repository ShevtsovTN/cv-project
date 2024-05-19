<?php

namespace App\Interfaces;

use App\Helpers\DatetimeHelper;
use App\Interfaces\Example\ProviderInterface;
use Illuminate\Support\Collection;

interface ApiRepositoryStatisticInterface
{
    public function getStatistics(ProviderInterface $provider, DatetimeHelper $datetimeHelper): Collection;
}
