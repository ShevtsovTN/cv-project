<?php

namespace App\Services;

use App\DTO\GetStatisticDTO;
use App\DTO\StatisticResponseDTO;
use App\Interfaces\StatisticRepositoryInterface;
use Illuminate\Support\Collection;

readonly class StatisticService
{
    public function __construct(private StatisticRepositoryInterface $statisticRepository)
    {
    }

    public function getAllBySite(int $siteId, GetStatisticDTO $dto): StatisticResponseDTO
    {
        return $this->statisticRepository->getAllBySite($siteId, $dto);
    }

    public function getAllByProvider(int $providerId, GetStatisticDTO $dto): StatisticResponseDTO
    {
        return $this->statisticRepository->getAllByProvider($providerId, $dto);
    }

    public function saveStatistic(Collection $statisticData): void
    {
        $this->statisticRepository->saveStatistic($statisticData);
    }
}
