<?php

namespace App\Http\Controllers;

use App\DTO\AttachSiteDTO;
use App\DTO\IndexDTO;
use App\DTO\StoreProviderDTO;
use App\DTO\UpdateProviderDTO;
use App\Http\Requests\AttachSiteRequest;
use App\Http\Requests\ProviderRequest;
use App\Http\Requests\StoreProviderRequest;
use App\Http\Requests\UpdateProviderRequest;
use App\Http\Resources\ProviderCollection;
use App\Http\Resources\ProviderResource;
use App\Services\ProviderService;
use Illuminate\Http\JsonResponse;

class ProviderController extends Controller
{
    public function __construct(protected ProviderService $providerService)
    {}

    public function index(ProviderRequest $request, IndexDTO $dto): ProviderCollection
    {
        $dto->setAttributes($request->validated());
        return ProviderCollection::make(
            $this->providerService->getMany($dto)
        );
    }

    public function store(StoreProviderRequest $request, StoreProviderDTO $storeProviderDTO): ProviderResource
    {
        $storeProviderDTO->setAttributes($request->validated());
        $provider = $this->providerService->create($storeProviderDTO);

        return ProviderResource::make($provider);
    }

    public function show(int $providerId): ProviderResource
    {
        return ProviderResource::make($this->providerService->getById($providerId));
    }

    public function update(UpdateProviderRequest $request, int $providerId, UpdateProviderDTO $updateProviderDTO): ProviderResource
    {
        $updateProviderDTO->setAttributes($request->validated());
        $updatedProvider = $this->providerService->update($providerId, $updateProviderDTO);

        return ProviderResource::make($updatedProvider);
    }

    public function destroy(int $providerId): JsonResponse
    {
        $this->providerService->delete($providerId);

        return response()->json(null, 204);
    }

    public function attachSite(AttachSiteRequest $request, int $providerId, AttachSiteDTO $attachSiteDTO): JsonResponse
    {
        $attachSiteDTO->setAttributes($request->validated());
        $this->providerService->attachSite($providerId, $attachSiteDTO);

        return response()->json(null, 204);
    }

    public function detachSite(int $providerId, int $siteId): JsonResponse
    {
        $this->providerService->detachSite($providerId, $siteId);

        return response()->json(null, 204);
    }
}
