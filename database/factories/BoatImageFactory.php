<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Boat;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BoatImage>
 */
class BoatImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $boat = Boat::inRandomOrder()->first();

        $boatId = $boat->id;
        $randomColor = $this->randomHexColor();
        $text = "Boat #{$boatId} - Image 1";

        $imageUrl = "https://dummyimage.com/800x600/{$randomColor}/fff&text=" . urlencode($text);

        return [
            'boat_id' => $boatId,
            'is_primary' => $this->faker->boolean,
            'path' => $imageUrl,
        ];
    }

    /**
     * Create multiple images for a boat with one marked as primary
     *
     * @param Boat $boat
     * @param int $numImages
     * @return void
     */
    public function createMultipleImagesForBoat(Boat $boat, int $numImages = 5)
    {
        for ($i = 1; $i <= $numImages; $i++) {
            $randomColor = $this->randomHexColor();
            $text = "Boat #{$boat->id} - Image {$i}";

            $this->create([
                'boat_id' => $boat->id,
                'is_primary' => $i === 1,
                'path' => "https://dummyimage.com/800x600/{$randomColor}/fff&text=" . urlencode($text),
            ]);
        }
    }

    /**
     * Generate a random hex color
     *
     * @return string
     */
    private function randomHexColor(): string
    {
        return sprintf('%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255));
    }
}
