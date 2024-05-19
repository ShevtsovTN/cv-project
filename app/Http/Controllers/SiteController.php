<?php

namespace App\Http\Controllers;

use App\DTO\IndexDTO;
use App\DTO\StoreSiteDTO;
use App\DTO\UpdateProviderSiteDTO;
use App\DTO\UpdateSiteDTO;
use App\Http\Requests\SitesRequest;
use App\Http\Requests\StoreSiteRequest;
use App\Http\Requests\UpdateProviderSiteRequest;
use App\Http\Requests\UpdateSiteRequest;
use App\Http\Resources\SiteCollection;
use App\Http\Resources\SiteResource;
use App\Models\Site;
use App\Services\SiteService;
use Illuminate\Http\JsonResponse;

class SiteController extends Controller
{
    public function __construct(protected SiteService $siteService)
    {}

    public function index(SitesRequest $request, IndexDTO $dto): SiteCollection
    {
        $dto->setAttributes($request->validated());
        return SiteCollection::make($this->siteService->getMany($dto));
    }

    public function store(StoreSiteRequest $request, StoreSiteDTO $storeSiteDTO): SiteResource
    {
        $storeSiteDTO->setAttributes($request->validated());
        $site = $this->siteService->create($storeSiteDTO);

        return SiteResource::make($site);
    }

    public function show(int $siteId): SiteResource
    {
        return SiteResource::make($this->siteService->getById($siteId));
    }

    public function update(UpdateSiteRequest $request, int $siteId, UpdateSiteDTO $updateSiteDTO): SiteResource
    {
        $updateSiteDTO->setAttributes($request->validated());
        $updatedSite = $this->siteService->update($siteId, $updateSiteDTO);

        return SiteResource::make($updatedSite);
    }

    public function destroy(int $site): JsonResponse
    {
        $this->siteService->delete($site);

        return response()->json(null, 204);
    }

    public function updateProviderSiteFields(
        int $siteId,
        int $providerId,
        UpdateProviderSiteRequest $request,
        UpdateProviderSiteDTO $updateProviderSiteDTO
    ): JsonResponse
    {
        $updateProviderSiteDTO->setAttributes($request->validated());
        $this->siteService->updateProviderSiteFields($siteId, $providerId, $updateProviderSiteDTO);

        return response()->json(null, 204);
    }
}
