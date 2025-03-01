<?php

namespace Database\Seeders;

use App\Models\BoatModel;
use Illuminate\Database\Seeder;
use App\Models\Manufacturer;
class ManufacturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Manufacturer::factory(10)->create()->each(function ($manufacturer) {
            $manufacturer->boatModels()->saveMany(BoatModel::factory()->count(rand(1, 3))->make());
        });
    }
}
