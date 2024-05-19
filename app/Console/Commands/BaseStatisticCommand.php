<?php

namespace App\Console\Commands;

use App\Helpers\DatetimeHelper;
use App\Interfaces\ApiRepositoryStatisticInterface;
use App\Interfaces\Example\ProviderInterface;
use App\Services\StatisticService;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;

class BaseStatisticCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:base-statistic-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @throws BindingResolutionException
     */
    protected function handleStatistic(
        ProviderInterface $provider,
        ApiRepositoryStatisticInterface $apiRepositoryStatistic,
        StatisticService $statisticService,
        ?DatetimeHelper $datetimeHelper = null
    ): void
    {

        if ($datetimeHelper === null) {
            $datetimeHelper = app()->make(DatetimeHelper::class);
        }

        $statisticData = $apiRepositoryStatistic->getStatistics($provider, $datetimeHelper);

        if ($this->option('d')) {
            dd($statisticData);
        } else {
            $statisticService->saveStatistic($statisticData);
        }
    }
}
