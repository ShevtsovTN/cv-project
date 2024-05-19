<?php

namespace App\Interfaces;

use App\DTO\IndexDTO;
use App\DTO\SiteDTO;
use App\DTO\StoreSiteDTO;
use App\DTO\UpdateProviderSiteDTO;
use App\DTO\UpdateSiteDTO;
use App\Models\Site;

interface SiteRepositoryInterface
{
    public function getMany(IndexDTO $dto);
    public function find(int $siteId): SiteDTO;
    public function create(StoreSiteDTO $storeSiteDTO): SiteDTO;
    public function update(UpdateSiteDTO $updateSiteDTO): SiteDTO;
    public function delete(int $siteId);

    public function updateExistingPivot(
        int $siteId,
        int $providerId,
        UpdateProviderSiteDTO $updateProviderSiteDTO
    );
}
