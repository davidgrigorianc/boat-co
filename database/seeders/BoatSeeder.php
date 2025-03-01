<?php

namespace Database\Seeders;


use App\Models\BoatImage;
use Illuminate\Database\Seeder;
use App\Models\Boat;
use App\Models\Engine;
class BoatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $boats = Boat::factory()->count(500)->create();
        $engines = [];

        foreach ($boats as $boat) {
            $num = rand(1, 4);
            for ($i = 0; $i < $num; $i++) {
                $engineData = Engine::factory()->definition();
                $engineData['boat_id'] = $boat->id;
                $engineData['created_at'] = now();
                $engineData['updated_at'] = now();

                $engines[] = $engineData;
            }

            $numImages = rand(2, 6);

            for ($i = 0; $i < $numImages; $i++) {
                $imageData = BoatImage::factory()->definition();
                $imageNumber = $i + 1;
                $text = "Boat #{$boat->id} - Image {$imageNumber}";
                $imageData['boat_id'] = $boat->id;
                $imageData['path'] = BoatImage::factory()->getImagePathByBoatIdAndText( $text );
                $imageData['created_at'] = now();
                $imageData['updated_at'] = now();

                $images[] = $imageData;
            }
        }

        Engine::insert($engines);
        BoatImage::insert($images);
    }
}
