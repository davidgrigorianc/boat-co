<?php

namespace Database\Seeders;


use App\Models\BoatModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Boat;
use App\Models\Manufacturer;
use App\Models\Location;
use App\Models\Engine;
class BoatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $boats =  Boat::factory()->count(1000)->create();
        foreach ($boats as $boat) {
            $num = rand(1, 4);
            Engine::factory()->createMultipleEnginesForBoat($boat, $num);
        }
    }
}
