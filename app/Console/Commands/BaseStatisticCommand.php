<?php

namespace App\Console\Commands;

use App\Helpers\DatetimeHelper;
use App\Interfaces\ApiRepositoryStatisticInterface;
use App\Interfaces\Example\ProviderInterface;
use App\Services\StatisticService;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Carbon;

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
            $datetimeHelper = app()->make(DatetimeHelper::class, [
                'dateFrom' => CarbonImmutable::now($this->argument('tz'))->startOfDay(),
                'dateTo' => CarbonImmutable::now($this->argument('tz'))->endOfDay(),
            ]);
        }

        $statisticData = $apiRepositoryStatistic->getStatistics($provider, $datetimeHelper);

        if ($this->option('d')) {
            $statisticData = $statisticData->groupBy(function ($item) {
                return Carbon::parse($item['collected_date'])->format('Y-m-d');
            });
            foreach ($statisticData as $index => $statisticDatum) {
                $this->line(sprintf('%s:', $index));
                $this->table(
                    ['site_id', 'collected_date', 'impressions', 'revenue', 'collected_at'],
                    $statisticDatum->transform(function ($item) {
                        return [
                            'site_id' => $item['site_id'],
                            'collected_date' => $item['collected_date'],
                            'impressions' => $item['impressions'],
                            'revenue' => $item['revenue'],
                            'collected_at' => $item['collected_at'],
                        ];
                    })
                );
            }
        } else {
            $statisticService->saveStatistic($statisticData);
        }
    }
}
