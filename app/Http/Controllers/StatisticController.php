<?php

namespace App\Http\Controllers;

use App\DTO\GetStatisticDTO;
use App\Http\Requests\GetStatisticRequest;
use App\Http\Resources\StatisticCollection;
use App\Services\StatisticService;
use OpenApi\Annotations as OA;


/**
 * @OA\Tag(name="Statistics")
 */
class StatisticController extends Controller
{
    public function __construct(protected StatisticService $siteStatisticService)
    {
    }

    /**
     * @OA\Get(
     *     path="/statistics/sites/{siteId}",
     *     operationId="getAllBySite",
     *     tags={"Statistics"},
     *     summary="Get statistics by site",
     *     @OA\Parameter(
     *           name="siteId",
     *           in="path",
     *           required=true,
     *           description="Site ID",
     *           @OA\Schema(type="integer")
     *       ),
     *     @OA\Parameter(
     *         name="sortBy",
     *         in="query",
     *         @OA\Schema(ref="#/components/schemas/GetStatisticRequest/properties/sortBy")
     *     ),
     *     @OA\Parameter(
     *         name="direction",
     *         in="query",
     *         @OA\Schema(ref="#/components/schemas/GetStatisticRequest/properties/direction")
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         @OA\Schema(ref="#/components/schemas/GetStatisticRequest/properties/page")
     *     ),
     *     @OA\Parameter(
     *         name="perPage",
     *         in="query",
     *         @OA\Schema(ref="#/components/schemas/GetStatisticRequest/properties/perPage")
     *     ),
     *     @OA\Parameter(
     *          name="dateFrom",
     *          in="query",
     *          @OA\Schema(ref="#/components/schemas/GetStatisticRequest/properties/dateFrom")
     *      ),
     *     @OA\Parameter(
     *          name="dateTo",
     *          in="query",
     *          @OA\Schema(ref="#/components/schemas/GetStatisticRequest/properties/dateTo")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Statistics by site",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/StatisticResource")
     *             ),
     *             @OA\Property(
     *                 property="total",
     *                 type="integer",
     *                 description="Total number of statistic objects"
     *             ),
     *             @OA\Property(
     *                 property="perPage",
     *                 type="integer",
     *                 description="Number of statistic objects per page"
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
    public function getAllBySite(int $site, GetStatisticRequest $request, GetStatisticDTO $dto): StatisticCollection
    {
        $dto->setAttributes($request->validated());

        $statisticDTO = $this->siteStatisticService->getAllBySite($site, $dto);

        return StatisticCollection::make($statisticDTO->getData())->additional([
            'total' => $statisticDTO->getPaginator()->getTotal(),
            'perPage' => $statisticDTO->getPaginator()->getPerPage(),
            'page' => $statisticDTO->getPaginator()->getPage(),
        ]);
    }

    /**
     * @OA\Get(
     *     path="/statistics/providers/{providerId}",
     *     operationId="getAllByProvider",
     *     tags={"Statistics"},
     *     summary="Get statistics by site",
     *     @OA\Parameter(
     *          name="providerId",
     *          in="path",
     *          required=true,
     *          description="Provider ID",
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\Parameter(
     *         name="sortBy",
     *         in="query",
     *         @OA\Schema(ref="#/components/schemas/GetStatisticRequest/properties/sortBy")
     *     ),
     *     @OA\Parameter(
     *         name="direction",
     *         in="query",
     *         @OA\Schema(ref="#/components/schemas/GetStatisticRequest/properties/direction")
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         @OA\Schema(ref="#/components/schemas/GetStatisticRequest/properties/page")
     *     ),
     *     @OA\Parameter(
     *         name="perPage",
     *         in="query",
     *         @OA\Schema(ref="#/components/schemas/GetStatisticRequest/properties/perPage")
     *     ),
     *     @OA\Parameter(
     *          name="dateFrom",
     *          in="query",
     *          @OA\Schema(ref="#/components/schemas/GetStatisticRequest/properties/dateFrom")
     *      ),
     *     @OA\Parameter(
     *          name="dateTo",
     *          in="query",
     *          @OA\Schema(ref="#/components/schemas/GetStatisticRequest/properties/dateTo")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Statistics by provider",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/StatisticResource")
     *             ),
     *             @OA\Property(
     *                 property="total",
     *                 type="integer",
     *                 description="Total number of statistic objects"
     *             ),
     *             @OA\Property(
     *                 property="perPage",
     *                 type="integer",
     *                 description="Number of statistic objects per page"
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
    public function getAllByProvider(
        int $provider,
        GetStatisticRequest $request,
        GetStatisticDTO $dto
    ): StatisticCollection {
        $dto->setAttributes($request->validated());

        $statisticDTO = $this->siteStatisticService->getAllByProvider($provider, $dto);

        return StatisticCollection::make($statisticDTO->getData())->additional([
            'total' => $statisticDTO->getPaginator()->getTotal(),
            'perPage' => $statisticDTO->getPaginator()->getPerPage(),
            'page' => $statisticDTO->getPaginator()->getPage(),
        ]);
    }
}
