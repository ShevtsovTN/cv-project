<?php

namespace App\Repositories\Entities;

use App\DTO\IndexDTO;
use App\DTO\SiteDTO;
use App\DTO\StoreSiteDTO;
use App\DTO\UpdateProviderSiteDTO;
use App\DTO\UpdateSiteDTO;
use App\Enums\PaginationEnum;
use App\Interfaces\SiteRepositoryInterface;
use App\Models\Site;
use Exception;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class SiteRepository implements SiteRepositoryInterface
{

    public function getMany(IndexDTO $dto): Paginator
    {
        return Site::query()
            ->when(!empty($dto->search), function ($query) use ($dto) {
                $query->where('name', 'like', '%' . $dto->search . '%')
                    ->orWhere('url', 'like', '%' . $dto->search . '%');
            })
            ->when(!empty($dto->sort) && !empty($dto->direction), function ($query) use ($dto) {
                $query->orderBy($dto->sort, $dto->direction);
            })
            ->simplePaginate($dto->per_page ?? PaginationEnum::PER_PAGE_10->value);
    }

    public function find(int $siteId): SiteDTO
    {
        /** @var Site $site */
        $site = Site::query()->findOrFail($siteId);
        return new SiteDTO($site->toArray());
    }

    /**
     * @throws Exception
     */
    public function create(StoreSiteDTO $storeSiteDTO): SiteDTO
    {
        DB::beginTransaction();

        try {
            /** @var Site $site */
            $site = Site::query()->create($storeSiteDTO->toArray());

            DB::commit();

            return new SiteDTO($site->toArray());
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @throws Exception
     */
    public function update(UpdateSiteDTO $updateSiteDTO): SiteDTO
    {
        DB::beginTransaction();
        try {
            /** @var Site $site */
            $site = Site::query()->findOrFail($updateSiteDTO->id);

            foreach ($updateSiteDTO->toArray() as $key => $value) {
                if ($value !== null) {
                    $site->{$key} = $value;
                }
            }

            $site->save();

            DB::commit();

            return new SiteDTO($site->refresh()->toArray());
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @throws Exception
     */
    public function delete(int $siteId): void
    {
        DB::beginTransaction();
        try {
            Site::query()->where('id', $siteId)->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateExistingPivot(
        int $siteId,
        int $providerId,
        UpdateProviderSiteDTO $updateProviderSiteDTO
    ): void {
        /** @var Site $site */
        $site = Site::query()->findOrFail($siteId);
        $site->providers()
            ->updateExistingPivot($providerId, $updateProviderSiteDTO->toArray());
    }
}
