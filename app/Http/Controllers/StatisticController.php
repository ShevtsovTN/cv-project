<?php

namespace App\Http\Controllers;

use App\DTO\GetStatisticDTO;
use App\Http\Requests\GetStatisticRequest;
use App\Http\Resources\StatisticCollection;
use App\Services\StatisticService;

class StatisticController extends Controller
{
    public function __construct(protected StatisticService $siteStatisticService)
    {}

    /**
     * Display a listing of the resource.
     */
    public function getAllBySite(int $site, GetStatisticRequest $request, GetStatisticDTO $dto): StatisticCollection
    {
        $dto->setAttributes($request->validated());

        $statisticDTO = $this->siteStatisticService->getAllByProvider($site, $dto);

        return StatisticCollection::make($statisticDTO->getData())->additional([
            'total' => $statisticDTO->getPaginator()->getTotal(),
            'perPage' => $statisticDTO->getPaginator()->getPerPage(),
            'page' => $statisticDTO->getPaginator()->getPage(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function getAllByProvider(int $provider, GetStatisticRequest $request, GetStatisticDTO $dto): StatisticCollection
    {
        $dto->setAttributes($request->validated());

        $statisticDTO = $this->siteStatisticService->getAllByProvider($provider, $dto);

        return StatisticCollection::make($statisticDTO->getData())->additional([
            'total' => $statisticDTO->getPaginator()->getTotal(),
            'perPage' => $statisticDTO->getPaginator()->getPerPage(),
            'page' => $statisticDTO->getPaginator()->getPage(),
        ]);
    }
}
