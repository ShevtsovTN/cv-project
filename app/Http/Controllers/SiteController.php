<?php

namespace App\Http\Controllers;

use App\DTO\IndexDTO;
use App\DTO\StoreSiteDTO;
use App\DTO\UpdateProviderSiteDTO;
use App\DTO\UpdateSiteDTO;
use App\Http\Requests\SiteRequest;
use App\Http\Requests\StoreSiteRequest;
use App\Http\Requests\UpdateProviderSiteRequest;
use App\Http\Requests\UpdateSiteRequest;
use App\Http\Resources\SiteCollection;
use App\Http\Resources\SiteResource;
use App\Models\Site;
use App\Services\SiteService;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(name="Sites")
 */
class SiteController extends Controller
{
    public function __construct(protected SiteService $siteService)
    {}

    /**
     * @OA\Get(
     *     path="/sites",
     *     operationId="getSites",
     *     tags={"Sites"},
     *     summary="Get list of sites",
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         @OA\Schema(ref="#/components/schemas/SiteRequest/properties/search")
     *     ),
     *     @OA\Parameter(
     *         name="sortBy",
     *         in="query",
     *         @OA\Schema(ref="#/components/schemas/SiteRequest/properties/sortBy")
     *     ),
     *     @OA\Parameter(
     *         name="direction",
     *         in="query",
     *         @OA\Schema(ref="#/components/schemas/SiteRequest/properties/direction")
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         @OA\Schema(ref="#/components/schemas/SiteRequest/properties/page")
     *     ),
     *     @OA\Parameter(
     *         name="perPage",
     *         in="query",
     *         @OA\Schema(ref="#/components/schemas/SiteRequest/properties/perPage")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="A list of sites",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/SiteResource")
     *             ),
     *             @OA\Property(
     *                 property="total",
     *                 type="integer",
     *                 description="Total number of sites"
     *             ),
     *             @OA\Property(
     *                 property="perPage",
     *                 type="integer",
     *                 description="Number of sites per page"
     *             ),
     *             @OA\Property(
     *                 property="page",
     *                 type="integer",
     *                 description="Current page number"
     *             )
     *         )
     *     )
     * )
     */
    public function index(SiteRequest $request, IndexDTO $dto): SiteCollection
    {
        $dto->setAttributes($request->validated());

        $sitesDTO = $this->siteService->getMany($dto);
        return SiteCollection::make($sitesDTO->getData())
            ->additional(['paginator' => $sitesDTO->getPaginator()]);
    }

    /**
     * @OA\Post(
     *     path="/sites",
     *     operationId="storeSite",
     *     tags={"Sites"},
     *     summary="Create site",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreSiteRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Site created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             ref="#/components/schemas/SiteResource"
     *         )
     *     )
     * )
     */
    public function store(StoreSiteRequest $request, StoreSiteDTO $storeSiteDTO): SiteResource
    {
        $storeSiteDTO->setAttributes($request->validated());
        $site = $this->siteService->create($storeSiteDTO);

        return SiteResource::make($site);
    }

    /**
     * @OA\Get(
     *     path="/sites/{siteId}",
     *     operationId="getSite",
     *     tags={"Sites"},
     *     summary="Get site's data",
     *     @OA\Parameter(
     *         name="siteId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="A site's data",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 ref="#/components/schemas/SiteResource"
     *             )
     *         )
     *     )
     * )
     */
    public function show(int $siteId): SiteResource
    {
        return SiteResource::make($this->siteService->getById($siteId));
    }

    /**
     * @OA\Put(
     *     path="/sites/{siteId}",
     *     operationId="updateSite",
     *     tags={"Sites"},
     *     summary="Update site",
     *     @OA\Parameter(
     *         name="siteId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateSiteRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Site updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             ref="#/components/schemas/SiteResource"
     *         )
     *     )
     * )
     */
    public function update(UpdateSiteRequest $request, int $siteId, UpdateSiteDTO $updateSiteDTO): SiteResource
    {
        $updateSiteDTO->setAttributes($request->validated());
        $updatedSite = $this->siteService->update($siteId, $updateSiteDTO);

        return SiteResource::make($updatedSite);
    }

    /**
     * @OA\Delete(
     *     path="/sites/{siteId}",
     *     operationId="deleteSite",
     *     tags={"Sites"},
     *     summary="Delete site",
     *     @OA\Parameter(
     *         name="siteId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Provider deleted successfully"
     *     )
     * )
     */
    public function destroy(int $site): JsonResponse
    {
        $this->siteService->delete($site);

        return response()->json(null, 204);
    }

    /**
     * @OA\Put(
     *     path="/sites/{siteId}/providers/{providerId}",
     *     operationId="updateProviderSiteFields",
     *     tags={"Sites"},
     *     summary="Update provider site fields",
     *     @OA\Parameter(
     *         name="siteId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="providerId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateProviderSiteRequest")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Provider site fields updated successfully"
     *     )
     * )
     */
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
