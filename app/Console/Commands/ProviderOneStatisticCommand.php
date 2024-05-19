<?php

namespace App\Console\Commands;

use App\Interfaces\ApiRepositoryStatisticInterface;
use App\Services\StatisticService;
use App\StatisticEntities\ExampleOne\ProviderOne;
use Illuminate\Contracts\Container\BindingResolutionException;

class ProviderOneStatisticCommand extends BaseStatisticCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-provider-one-statistic-command {from?} {to?} {tz=UTC} {--d}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handle statistics from ProviderOne provider.';

    /**
     * Execute the console command.
     * @throws BindingResolutionException
     */
    public function handle(
        ProviderOne $provider,
        ApiRepositoryStatisticInterface $apiRepositoryStatistic,
        StatisticService $service,
    ): void
    {
        $this->handleStatistic($provider, $apiRepositoryStatistic, $service);
    }
}
