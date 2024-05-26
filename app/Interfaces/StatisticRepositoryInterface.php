<?php

namespace App\Interfaces;

use App\DTO\GetStatisticDTO;
use App\DTO\ResponseDTO;
use Illuminate\Support\Collection;

interface StatisticRepositoryInterface
{
    public function getAllBySite(int $siteId, GetStatisticDTO $dto): ResponseDTO;

    public function getAllByProvider(int $providerId, GetStatisticDTO $dto): ResponseDTO;

    public function saveStatistic(Collection $statisticData): void;
}
