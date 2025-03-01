<?php

namespace App\Repositories\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;
interface BoatModelRepositoryInterface
{
    public function getBoatModelsByManufacturerId(int $id);
}
