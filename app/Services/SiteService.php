<?php

namespace App\Services;

use App\DTO\IndexDTO;
use App\DTO\SiteDTO;
use App\DTO\StoreSiteDTO;
use App\DTO\UpdateProviderSiteDTO;
use App\DTO\UpdateSiteDTO;
use App\Interfaces\SiteRepositoryInterface;
use App\Models\Site;
use Illuminate\Support\Str;

readonly class SiteService
{
    public function __construct(private SiteRepositoryInterface $siteRepository)
    {}

    public function getMany(IndexDTO $dto)
    {
        // Some logic here
        return $this->siteRepository->getMany($dto);
    }

    public function create(StoreSiteDTO $storeSiteDTO): SiteDTO
    {
        // Some logic here
        return $this->siteRepository->create($storeSiteDTO);
    }

    public function getById(int $id): SiteDTO
    {
        // Some logic here
        return $this->siteRepository->find($id);
    }

    public function update(int $siteId, UpdateSiteDTO $updateSiteDTO): SiteDTO
    {
        $updateSiteDTO->id = $siteId;
        return $this->siteRepository->update($updateSiteDTO);
    }

    public function delete(int $siteId): void
    {
        // Some logic here
        $this->siteRepository->delete($siteId);
    }

    public function updateProviderSiteFields(
        int $siteId,
        int $providerId,
        UpdateProviderSiteDTO $updateProviderSiteDTO
    ): void {
        // Some logic here
        $this->siteRepository->updateExistingPivot($siteId, $providerId, $updateProviderSiteDTO);
    }
}
