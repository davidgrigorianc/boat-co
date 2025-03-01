<?php

namespace App\Repositories\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;
interface BoatRepositoryInterface
{
    public function getFilteredBoats(array $filters): LengthAwarePaginator;
    public function getBoatById(int $id);
    public function getManufacturers();
    public function getBoatModelsByManufacturerId(int $manufacturerId);
}
