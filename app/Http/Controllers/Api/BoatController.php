<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetBoatModelsRequest;
use App\Http\Requests\GetBoatsRequest;
use App\Http\Resources\BoatDetailResource;
use App\Http\Resources\BoatResource;
use App\Repositories\Contracts\BoatRepositoryInterface;
use App\Repositories\Contracts\ManufacturerRepositoryInterface;
use App\Repositories\Contracts\BoatModelRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;

class BoatController extends Controller
{
    protected BoatRepositoryInterface $boatRepository;
    protected ManufacturerRepositoryInterface $manufacturerRepository;
    protected BoatModelRepositoryInterface $boatModelRepository;

    public function __construct(
        BoatRepositoryInterface $boatRepository,
        ManufacturerRepositoryInterface $manufacturerRepository,
        BoatModelRepositoryInterface $boatModelRepository
    ) {
        $this->boatRepository = $boatRepository;
        $this->manufacturerRepository = $manufacturerRepository;
        $this->boatModelRepository = $boatModelRepository;
    }

    /**
     * Fetch filtered boats.
     */
    public function index(GetBoatsRequest $request): AnonymousResourceCollection|JsonResponse
    {
        try {
            $boats = $this->boatRepository->getFilteredBoats($request->validated());
            return BoatResource::collection($boats);
        } catch (\Throwable $e) {
            Log::error(__METHOD__ . ' - Error fetching boats', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Something went wrong. Please try again later.'], 500);
        }
    }

    /**
     * Show boat details.
     */
    public function show(int $id): BoatDetailResource|JsonResponse
    {
        try {
            $boat = $this->boatRepository->getBoatById($id);
            return new BoatDetailResource($boat);
        } catch (\Throwable $e) {
            Log::error(__METHOD__ . ' - Error fetching boat details', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Boat not found.'], 404);
        }
    }

    /**
     * Get list of manufacturers.
     */
    public function getManufacturers(): JsonResponse
    {
        try {
            $manufacturers = $this->manufacturerRepository->getManufacturers();
            return response()->json($manufacturers);
        } catch (\Throwable $e) {
            Log::error(__METHOD__ . ' - Error fetching manufacturers', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Unable to fetch manufacturers.'], 500);
        }
    }

    /**
     * Get list of boat models by manufacturer.
     */
    public function getBoatModels(GetBoatModelsRequest $request): JsonResponse
    {
        try {
            $manufacturerId = (int) $request->validated()['manufacturer_id'];
            $models = $this->boatModelRepository->getBoatModelsByManufacturerId($manufacturerId);
            return response()->json($models);
        } catch (\Throwable $e) {
            Log::error(__METHOD__ . ' - Error fetching boat models', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Unable to fetch boat models.'], 500);
        }
    }
}
