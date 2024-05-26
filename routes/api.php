<?php

use App\Http\Controllers\ProviderController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\StatisticController;
use Illuminate\Support\Facades\Route;

Route::apiResources([
    'sites' => SiteController::class,
    'providers' => ProviderController::class,
]);

Route::post('providers/{provider}/sites', [ProviderController::class, 'attachSite'])
    ->name('providers.sites.attach');
Route::delete('providers/{provider}/sites/{site}', [ProviderController::class, 'detachSite'])
    ->name('providers.sites.detach');

Route::get('statistics/sites/{site}', [StatisticController::class, 'getAllBySite'])
    ->name('statistics.site');
Route::get('statistics/providers/{provider}', [StatisticController::class, 'getAllByProvider'])
    ->name('statistics.provider');

Route::patch(
    'sites/{site}/providers/{provider}/update-fields',
    [SiteController::class, 'updateProviderSiteFields']
)->name('sites.providers.update-fields');
