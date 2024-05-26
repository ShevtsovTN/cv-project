<?php

namespace App\Interfaces;

use App\DTO\GetStatisticDTO;
use App\DTO\StatisticResponseDTO;
use Illuminate\Support\Collection;

interface StatisticRepositoryInterface
{
    public function getAllBySite(int $siteId, GetStatisticDTO $dto): StatisticResponseDTO;

    public function getAllByProvider(int $providerId, GetStatisticDTO $dto): StatisticResponseDTO;

    public function saveStatistic(Collection $statisticData): void;
}
