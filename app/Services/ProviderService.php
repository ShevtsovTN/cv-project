<?php

namespace App\Services;

use App\DTO\AttachSiteDTO;
use App\DTO\IndexDTO;
use App\DTO\ProviderDTO;
use App\DTO\StoreProviderDTO;
use App\DTO\UpdateProviderDTO;
use App\Interfaces\ProviderRepositoryInterface;
use App\Models\Provider;

readonly class ProviderService
{
    public function __construct(private ProviderRepositoryInterface $providerRepository)
    {}

    public function getMany(IndexDTO $dto)
    {
        // Some logic here
        return $this->providerRepository->getMany($dto);
    }

    public function create(StoreProviderDTO $providerDTO): ProviderDTO
    {
        // Some logic here
        return $this->providerRepository->create($providerDTO);
    }

    public function getById(int $id): ProviderDTO
    {
        // Some logic here
        return $this->providerRepository->find($id);
    }

    public function update(int $providerId, UpdateProviderDTO $updateProviderDTO): ProviderDTO
    {
        $updateProviderDTO->id = $providerId;
        return $this->providerRepository->update($updateProviderDTO);
    }

    public function delete(int $provider): void
    {
        // Some logic here
        $this->providerRepository->delete($provider);
    }

    public function attachSite(int $provider, AttachSiteDTO $attachSiteDTO): void
    {
        // Some logic here
        $this->providerRepository->attachSite($provider, $attachSiteDTO);
    }

    public function detachSite(int $provider, int $siteId): void
    {
        // Some logic here
        $this->providerRepository->detachSite($provider, $siteId);
    }
}
