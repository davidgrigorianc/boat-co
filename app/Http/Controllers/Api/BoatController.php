<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetBoatModelsRequest;
use App\Http\Requests\GetBoatsRequest;
use App\Http\Resources\BoatDetailResource;
use App\Http\Resources\BoatResource;
use App\Repositories\Contracts\BoatRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;

class BoatController extends Controller
{
    protected BoatRepositoryInterface $boatRepository;

    public function __construct(BoatRepositoryInterface $boatRepository)
    {
        $this->boatRepository = $boatRepository;
    }

    /**
     * Fetch filtered boats
     *
     * @param GetBoatsRequest $request
     * @return AnonymousResourceCollection|JsonResponse
     */
    public function index(GetBoatsRequest $request): AnonymousResourceCollection|JsonResponse
    {
        try {
            $boats = $this->boatRepository->getFilteredBoats($request->all());
            return BoatResource::collection($boats);
        } catch (\Throwable $e) {
            Log::error('Error fetching boats', ['error' => $e->getMessage()]);

            return response()->json([
                'error' => 'Something went wrong. Please try again later.'
            ], 500);
        }
    }

    /**
     * Show boat details
     *
     * @param int $id
     * @return BoatDetailResource|JsonResponse
     */
    public function show(int $id): BoatDetailResource|JsonResponse
    {
        try {
            $boat = $this->boatRepository->getBoatById($id);
            return new BoatDetailResource($boat);
        } catch (\Throwable $e) {
            Log::error('Error fetching boat details', ['error' => $e->getMessage()]);
            return response()->json([
                'error' => 'Boat not found.'
            ], 404);
        }
    }

    /**
     * Get list of manufacturers
     *
     * @return JsonResponse
     */
    public function getManufacturers(): JsonResponse
    {
        $manufacturers = $this->boatRepository->getManufacturers();
        return response()->json($manufacturers);
    }

    /**
     * Get list of boat models by manufacturer
     *
     * @param GetBoatModelsRequest $request
     * @return JsonResponse
     */
    public function getBoatModels(GetBoatModelsRequest $request): JsonResponse
    {
        $models = $this->boatRepository->getBoatModelsByManufacturerId($request->manufacturer_id);
        return response()->json($models);
    }
}
