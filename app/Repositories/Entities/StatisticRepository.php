<?php

namespace App\Repositories\Entities;

use App\DTO\GetStatisticDTO;
use App\DTO\PaginatorDTO;
use App\DTO\ProviderDTO;
use App\DTO\SiteDTO;
use App\DTO\StatisticResponseDTO;
use App\Interfaces\ProviderRepositoryInterface;
use App\Interfaces\SiteRepositoryInterface;
use App\Interfaces\StatisticRepositoryInterface;
use App\Models\Statistic;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\HigherOrderWhenProxy;

readonly class StatisticRepository implements StatisticRepositoryInterface
{
    public function __construct(
        private SiteRepositoryInterface $siteRepository,
        private ProviderRepositoryInterface $providerRepository
    ) {
    }

    public function getAllBySite(int $siteId, GetStatisticDTO $dto): StatisticResponseDTO
    {
        $site = $this->siteRepository->find($siteId);

        $statisticsQuery = $this->getStatisticBaseQuery($site, $dto);

        $total = $statisticsQuery->count();

        /** @var Collection $statistics */
        $statistics = $statisticsQuery
            ->orderBy($dto->getSortBy(), $dto->getDirection())
            ->offset($dto->getOffset())
            ->limit($dto->getPerPage())
            ->get();

        return $this->getStatisticResponseDTO($statistics, $total, $dto);
    }

    public function getAllByProvider(int $providerId, GetStatisticDTO $dto): StatisticResponseDTO
    {
        $provider = $this->providerRepository->find($providerId);

        $statisticsQuery = $this->getStatisticBaseQuery($provider, $dto);

        $total = $statisticsQuery->count();

        /** @var Collection $statistics */
        $statistics = $statisticsQuery
            ->orderBy($dto->getSortBy(), $dto->getDirection())
            ->offset($dto->getOffset())
            ->limit($dto->getPerPage())
            ->get();

        return $this->getStatisticResponseDTO($statistics, $total, $dto);
    }

    public function saveStatistic(Collection $statisticData): void
    {
        Statistic::query()->upsert(
            $statisticData->toArray(),
            ['collected_date', 'site_id'],
            ['impressions', 'revenue']
        );
    }

    /**
     * @param Collection $statistics
     * @param int $total
     * @param GetStatisticDTO $dto
     * @return StatisticResponseDTO
     */
    private function getStatisticResponseDTO(Collection $statistics, int $total, GetStatisticDTO $dto): StatisticResponseDTO
    {
        return (new StatisticResponseDTO())
            ->setStatistics($statistics)
            ->setPaginator(
                new PaginatorDTO([
                    'total' => $total,
                    'perPage' => $dto->getPerPage(),
                    'currentPage' => $dto->getPage(),
                ])
            );
    }

    /**
     * @param ProviderDTO|SiteDTO $statisticObject
     * @param GetStatisticDTO $dto
     * @return Builder
     */
    private function getStatisticBaseQuery(
        ProviderDTO|SiteDTO $statisticObject,
        GetStatisticDTO $dto
    ): Builder
    {
        return Statistic::query()
            ->where(function (Builder $query) use ($statisticObject) {
                $query = match (true) {
                    $statisticObject instanceof ProviderDTO => $query->where('provider_id', $statisticObject->id),
                    $statisticObject instanceof SiteDTO => $query->where('site_id', $statisticObject->id),
                };
            })
            ->when(!empty($dto->getStartDate()), function (Builder $query) use ($dto) {
                $query->whereDate('collected_date', '>=', $dto->getStartDate());
            })
            ->when(!empty($dto->getEndDate()), function (Builder $query) use ($dto) {
                $query->whereDate('collected_date', '<=', $dto->getEndDate());
            });
    }
}
