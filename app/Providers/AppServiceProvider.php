<?php

namespace App\Providers;

use App\Console\Commands\ProviderOneStatisticCommand;
use App\Console\Commands\ProviderTwoStatisticCommand;
use App\Interfaces\ApiRepositoryStatisticInterface;
use App\Interfaces\ProviderRepositoryInterface;
use App\Interfaces\SiteRepositoryInterface;
use App\Interfaces\StatisticRepositoryInterface;
use App\Repositories\Entities\ProviderRepository;
use App\Repositories\Entities\SiteRepository;
use App\Repositories\Entities\StatisticRepository;
use App\Repositories\ProviderOneApiRepository;
use App\Repositories\ProviderTwoApiRepository;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SiteRepositoryInterface::class, SiteRepository::class);
        $this->app->bind(ProviderRepositoryInterface::class, ProviderRepository::class);
        $this->app->bind(StatisticRepositoryInterface::class, StatisticRepository::class);

        $this->app->when([ProviderOneStatisticCommand::class])
            ->needs(ApiRepositoryStatisticInterface::class)
            ->give(function () {
                $httpClient = Http::baseUrl(config('api.ProviderOne.url'));
                return new ProviderOneApiRepository($httpClient);
            });

        $this->app->when([ProviderTwoStatisticCommand::class])
            ->needs(ApiRepositoryStatisticInterface::class)
            ->give(function () {
                $httpClient = Http::baseUrl(config('api.ProviderTwo.url'));
                return new ProviderTwoApiRepository($httpClient);
            });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
