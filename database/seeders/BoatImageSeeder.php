<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Boat;
use App\Models\BoatImage;

class BoatImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Boat::all()->each(function ($boat) {
            $numImages = rand(2, 6);
            BoatImage::factory()->createMultipleImagesForBoat($boat, $numImages);
        });
    }
}
