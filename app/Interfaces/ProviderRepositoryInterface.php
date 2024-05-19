<?php

namespace App\Interfaces;

use App\DTO\AttachSiteDTO;
use App\DTO\IndexDTO;
use App\DTO\ProviderDTO;
use App\DTO\StoreProviderDTO;
use App\DTO\UpdateProviderDTO;
use Illuminate\Support\Collection;

interface ProviderRepositoryInterface
{
    public function getMany(IndexDTO $dto);

    public function getById(int $id): ProviderDTO;

    public function getByTechName(string $techName): ProviderDTO;

    public function create(StoreProviderDTO $providerDTO): ProviderDTO;

    public function update(UpdateProviderDTO $updateProviderDTO): ProviderDTO;

    public function delete(int $providerId);

    public function attachSite(int $providerId, AttachSiteDTO $attachSiteDTO);

    public function detachSite(int $providerId, int $siteId);

    public function getSitesForStatistic(int $providerId, array $whereData): Collection;
}
