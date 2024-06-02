<?php

namespace App\Console\Commands;

use App\Interfaces\ApiRepositoryStatisticInterface;
use App\Services\StatisticService;
use App\StatisticEntities\ExampleTwo\ProviderTwo;
use Illuminate\Contracts\Container\BindingResolutionException;

class ProviderTwoStatisticCommand extends BaseStatisticCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-provider-two-statistic-command {from?} {to?} {tz=Europe/Madrid} {--d}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handle statistics from ProviderTwo provider.';

    /**
     * Execute the console command.
     * @throws BindingResolutionException
     */
    public function handle(
        ProviderTwo $provider,
        ApiRepositoryStatisticInterface $apiRepositoryStatistic,
        StatisticService $service,
    ): void
    {
        $this->handleStatistic($provider, $apiRepositoryStatistic, $service);
    }
}
