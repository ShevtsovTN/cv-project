<?php

namespace App\Repositories\Entities;

use App\DTO\AttachSiteDTO;
use App\DTO\GetStatisticDTO;
use App\DTO\IndexDTO;
use App\DTO\PaginatorDTO;
use App\DTO\ProviderDTO;
use App\DTO\ResponseDTO;
use App\DTO\SiteDTO;
use App\DTO\SiteForProviderDTO;
use App\DTO\StoreProviderDTO;
use App\DTO\UpdateProviderDTO;
use App\Enums\PaginationEnum;
use App\Interfaces\ProviderRepositoryInterface;
use App\Models\Provider;
use Exception;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProviderRepository implements ProviderRepositoryInterface
{
    public function getMany(IndexDTO $dto): ResponseDTO
    {
        $baseQuery = Provider::query()
            ->when(!empty($dto->getSearch()), function ($query) use ($dto) {
                $query->where('name', 'like', '%' . $dto->getSearch() . '%');
            })
            ->when(!empty($dto->getSortBy()) && !empty($dto->getDirection()), function ($query) use ($dto) {
                $query->orderBy($dto->getSortBy(), $dto->getDirection());
            });

        $total = $baseQuery->count();

        $providers = $baseQuery
            ->offset($dto->getOffset())
            ->limit($dto->getPerPage())
            ->get();

        return $this->getResponseDTO($providers, $total, $dto);
    }

    public function find(int $id): ProviderDTO
    {
        /** @var Provider $provider */
        $provider = Provider::query()->findOrFail($id);
        return new ProviderDTO($provider->toArray());
    }

    /**
     * @throws Exception
     */
    public function create(StoreProviderDTO $providerDTO): ProviderDTO
    {
        DB::beginTransaction();

        try {
            /** @var Provider $provider */
            $provider = Provider::query()->create($providerDTO->toArray());

            DB::commit();

            return new ProviderDTO($provider->toArray());

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @throws Exception
     */
    public function update(UpdateProviderDTO $updateProviderDTO): ProviderDTO
    {
        DB::beginTransaction();

        try {
            /** @var Provider $provider */
            $provider = Provider::query()
                ->where('id', $updateProviderDTO->id)
                ->firstOrFail();

            foreach ($updateProviderDTO->toArray() as $key => $value) {
                if ($value !== null) {
                    $provider->{$key} = $value;
                }
            }

            $provider->save();

            DB::commit();

            return new ProviderDTO($provider->refresh()->toArray());

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @throws Exception
     */
    public function delete(int $providerId): void
    {
        DB::beginTransaction();

        try {
            Provider::query()->where('id', $providerId)->delete();

            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @throws Exception
     */
    public function attachSite(int $providerId, AttachSiteDTO $attachSiteDTO): void
    {
        DB::beginTransaction();

        try {
            /** @var Provider $provider */
            $provider = Provider::query()->findOrFail($providerId);

            $provider->sites()->attach(
                $attachSiteDTO->site_id,
                [
                    'active' => $attachSiteDTO->active,
                    'external_id' => $attachSiteDTO->external_id,
                ]
            );

            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @throws Exception
     */
    public function detachSite(int $providerId, int $siteId): void
    {
        DB::beginTransaction();
        try {
            /** @var Provider $provider */
            $provider = Provider::query()->findOrFail($providerId);

            $provider->sites()->detach($siteId);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getByTechName(string $techName): ProviderDTO
    {
        /** @var Provider $provider */
        $provider = Provider::query()->where('tech_name', $techName)->first();
        return new ProviderDTO($provider->toArray());
    }

    public function getSitesForStatistic(int $providerId, array $whereData): Collection
    {
        return Provider::query()
            ->where('id', $providerId)
            ->withWhereHas('sites', function ($query) use ($whereData) {
                $query->where($whereData);
            })
            ->get()
        ->flatMap(function (Provider $provider) {
            return collect($provider['sites'])->map(function ($site) {
                return new SiteForProviderDTO([
                    'id' => $site['pivot']['site_id'],
                    'external_id' => $site['pivot']['external_id']
                ]);
            });
        });
    }

    private function getResponseDTO(Collection $providers, int $total, IndexDTO $dto): ResponseDTO
    {
        return (new ResponseDTO())
            ->setData($providers->map(fn(Provider $provider) => new ProviderDTO($provider->toArray())))
            ->setPaginator(
                new PaginatorDTO([
                    'total' => $total,
                    'perPage' => $dto->getPerPage(),
                    'currentPage' => $dto->getPage(),
                ])
            );
    }
}
