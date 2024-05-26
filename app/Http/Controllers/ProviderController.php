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
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(name="Providers")
 */
class ProviderController extends Controller
{
    public function __construct(protected ProviderService $providerService)
    {}

    /**
     * @OA\Get(
     *     path="/providers",
     *     operationId="getProviders",
     *     tags={"Providers"},
     *     summary="Get list of providers",
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         @OA\Schema(ref="#/components/schemas/ProviderRequest/properties/search")
     *     ),
     *     @OA\Parameter(
     *         name="sortBy",
     *         in="query",
     *         @OA\Schema(ref="#/components/schemas/ProviderRequest/properties/sortBy")
     *     ),
     *     @OA\Parameter(
     *         name="direction",
     *         in="query",
     *         @OA\Schema(ref="#/components/schemas/ProviderRequest/properties/direction")
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         @OA\Schema(ref="#/components/schemas/ProviderRequest/properties/page")
     *     ),
     *     @OA\Parameter(
     *         name="perPage",
     *         in="query",
     *         @OA\Schema(ref="#/components/schemas/ProviderRequest/properties/perPage")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="A list of providers",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/ProviderResource")
     *             ),
     *             @OA\Property(
     *                 property="total",
     *                 type="integer",
     *                 description="Total number of providers"
     *             ),
     *             @OA\Property(
     *                 property="perPage",
     *                 type="integer",
     *                 description="Number of providers per page"
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
    public function index(ProviderRequest $request, IndexDTO $dto): ProviderCollection
    {
        $dto->setAttributes($request->validated());

        $providersDTO = $this->providerService->getMany($dto);

        return ProviderCollection::make($providersDTO->getData())
            ->additional(['paginator' => $providersDTO->getPaginator()]);
    }

    /**
     * @OA\Post(
     *     path="/providers",
     *     operationId="storeProvider",
     *     tags={"Providers"},
     *     summary="Create provider",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             ref="#/components/schemas/StoreProviderRequest"
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Provider created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 ref="#/components/schemas/ProviderResource"
     *             )
     *         )
     *     )
     * )
     */
    public function store(StoreProviderRequest $request, StoreProviderDTO $storeProviderDTO): ProviderResource
    {
        $storeProviderDTO->setAttributes($request->validated());
        $provider = $this->providerService->create($storeProviderDTO);

        return ProviderResource::make($provider);
    }

    /**
     * @OA\Get(
     *     path="/providers/{providerId}",
     *     operationId="getProvider",
     *     tags={"Providers"},
     *     summary="Get provider's data",
     *     @OA\Parameter(
     *         name="providerId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="A provider's data",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 ref="#/components/schemas/ProviderResource"
     *             )
     *         )
     *     )
     * )
     */
    public function show(int $providerId): ProviderResource
    {
        return ProviderResource::make($this->providerService->getById($providerId));
    }

    /**
     * @OA\Put(
     *     path="/providers/{providerId}",
     *     operationId="updateProvider",
     *     tags={"Providers"},
     *     summary="Update provider",
     *     @OA\Parameter(
     *         name="providerId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             ref="#/components/schemas/UpdateProviderRequest"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Provider updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 ref="#/components/schemas/ProviderResource"
     *             )
     *         )
     *     )
     * )
     */
    public function update(UpdateProviderRequest $request, int $providerId, UpdateProviderDTO $updateProviderDTO): ProviderResource
    {
        $updateProviderDTO->setAttributes($request->validated());
        $updatedProvider = $this->providerService->update($providerId, $updateProviderDTO);

        return ProviderResource::make($updatedProvider);
    }

    /**
     * @OA\Delete(
     *     path="/providers/{providerId}",
     *     operationId="deleteProvider",
     *     tags={"Providers"},
     *     summary="Delete provider",
     *     @OA\Parameter(
     *         name="providerId",
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
    public function destroy(int $providerId): JsonResponse
    {
        $this->providerService->delete($providerId);

        return response()->json(null, 204);
    }

    /**
     * @OA\Post(
     *     path="/providers/{providerId}/sites",
     *     operationId="attachSite",
     *     tags={"Providers"},
     *     summary="Attach site to provider",
     *     @OA\Parameter(
     *         name="providerId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *          name="site_id",
     *          in="query",
     *          required=true,
     *          @OA\Schema(ref="#/components/schemas/AttachSiteRequest/properties/site_id")
     *      ),
     *      @OA\Parameter(
     *          name="active",
     *          in="query",
     *          required=true,
     *          @OA\Schema(ref="#/components/schemas/AttachSiteRequest/properties/active")
     *      ),
     *      @OA\Parameter(
     *          name="external_id",
     *          in="query",
     *          required=true,
     *          @OA\Schema(ref="#/components/schemas/AttachSiteRequest/properties/external_id")
     *      ),
     *     @OA\Response(
     *         response=204,
     *         description="Site attached successfully"
     *     )
     * )
     */
    public function attachSite(AttachSiteRequest $request, int $providerId, AttachSiteDTO $attachSiteDTO): JsonResponse
    {
        $attachSiteDTO->setAttributes($request->validated());
        $this->providerService->attachSite($providerId, $attachSiteDTO);

        return response()->json(null, 204);
    }

    /**
     * @OA\Delete(
     *     path="/providers/{providerId}/sites/{siteId}",
     *     operationId="detachSite",
     *     tags={"Providers"},
     *     summary="Detach site from provider",
     *     @OA\Parameter(
     *         name="providerId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
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
     *         description="Site detached successfully"
     *     )
     * )
     */
    public function detachSite(int $providerId, int $siteId): JsonResponse
    {
        $this->providerService->detachSite($providerId, $siteId);

        return response()->json(null, 204);
    }
}
