<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetStatisticRequest;
use App\Models\Provider;
use App\Models\Site;
use App\Services\StatisticService;
use Illuminate\Database\Eloquent\Collection;

class StatisticController extends Controller
{
    public function __construct(protected StatisticService $siteStatisticService)
    {}

    /**
     * Display a listing of the resource.
     */
    public function getAllBySite(Site $site, GetStatisticRequest $request): Collection
    {
        return $this->siteStatisticService->getAllBySite($site, $request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function getAllByProvider(Provider $provider, GetStatisticRequest $request): Collection
    {
        return $this->siteStatisticService->getAllByProvider($provider, $request->validated());
    }
}
