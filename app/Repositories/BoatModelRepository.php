<?php

namespace App\Repositories;

use App\Repositories\Contracts\BoatModelRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Models\BoatModel;

class BoatModelRepository extends BaseRepository implements BoatModelRepositoryInterface
{
    public function __construct(BoatModel $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all boat models by manufacturer ID.
     *
     * @param int $id
     * @return Collection
     */
    public function getBoatModelsByManufacturerId(int $id): Collection
    {
        return $this->model::where('manufacturer_id', $id)->select('id', 'name')->get();
    }
}
