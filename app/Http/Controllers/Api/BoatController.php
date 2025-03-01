<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\BoatDetailResource;
use App\Models\Boat;
use App\Models\BoatModel;
use App\Models\Manufacturer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BoatResource;
use Illuminate\Support\Facades\Log;

class BoatController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Boat::filterByStatus('available')
                ->filterByCategory($request->boat_type)
                ->filterByCondition($request->condition)
                ->filterByBoatModel($request->boat_model_id)
                ->filterByLength($request->length ?? [])
                ->filterByYear($request->year ?? [])
                ->filterByPrice($request->price ?? [])
                ->orderByColumn($request->sort ?? 'created_at', $request->direction ?? 'asc');

            if (!$request->boat_model_id) {
                $query->filterByManufacturer($request->manufacturer_id);
            }
            $boats = $query->paginate($request->get('per_page', 9));

            return BoatResource::collection($boats);
        } catch (\Exception $e) {
            Log::error('Error fetching boats: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while fetching boats.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }



    public function show($id)
    {
        $boat = Boat::findOrFail($id);

        return new BoatDetailResource($boat);
    }

    public function getManufacturers()
    {
        return response()->json(Manufacturer::select('id', 'name')->get());
    }

    public function getBoatModels(Request $request)
    {
        $models = BoatModel::where('manufacturer_id', $request->manufacturer_id)->select('id', 'name')->get();
        return response()->json($models);
    }
}
