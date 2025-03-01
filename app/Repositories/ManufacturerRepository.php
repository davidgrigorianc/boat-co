<?php

namespace App\Repositories;

use App\Repositories\Contracts\ManufacturerRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Manufacturer;

class ManufacturerRepository extends BaseRepository implements ManufacturerRepositoryInterface
{
    public function __construct(Manufacturer $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all boat models by manufacturer ID.
     *
     * @return Collection
     */
    public function getManufacturers(): Collection
    {
        return $this->model::select('id', 'name')->get();
    }
}
