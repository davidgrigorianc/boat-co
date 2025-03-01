<?php

namespace App\Repositories;

use App\Models\Boat;
use App\Repositories\Contracts\BoatRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class BoatRepository extends BaseRepository implements BoatRepositoryInterface
{
    public function __construct(Boat $model)
    {
        parent::__construct($model);
    }

    /**
     * Get filtered boats based on provided filters.
     *
     * @param  array  $filters
     * @return LengthAwarePaginator
     */
    public function getFilteredBoats(array $filters): LengthAwarePaginator
    {
        $query = $this->model->newQuery();

        if (isset($filters['boat_type']) && $filters['boat_type'] !== 'all') {
            $query->where('boat_type', $filters['boat_type']);
        }

        if (isset($filters['condition']) && $filters['condition'] !== 'all') {
            $isNew = $filters['condition'] === 'new' ? 1 : 0;
            $query->where('is_new', $isNew);
        }

        if (isset($filters['boat_model_id'])) {
            $query->where('boat_model_id', $filters['boat_model_id']);
        }

        if (!empty($filters['length']) && count($filters['length']) === 2) {
            $query->whereBetween('length', $filters['length']);
        }

        if (!empty($filters['year']) && count($filters['year']) === 2) {
            $query->whereBetween('year', $filters['year']);
        }

        if (!empty($filters['price']) && count($filters['price']) === 2) {
            $query->whereBetween('price', $filters['price']);
        }

        if (isset($filters['manufacturer_id']) && empty($filters['boat_model_id'])) {
            $query->whereHas('boat_model.manufacturer', function ($query) use ($filters) {
                $query->where('id', $filters['manufacturer_id']);
            });
        }

        // Sorting
        $sortColumn = $filters['sort'] ?? 'created_at';
        $sortDirection = $filters['direction'] ?? 'asc';

        if (in_array($sortColumn, ['price', 'length', 'year', 'created_at'])) {
            $query->orderBy($sortColumn, $sortDirection);
        }

        return $query->paginate($filters['per_page'] ?? 9);
    }

    /**
     * Get a boat by its ID.
     *
     * @param  int  $id
     * @return Boat
     */
    public function getBoatById(int $id): Boat
    {
        return $this->findById($id);
    }
}
