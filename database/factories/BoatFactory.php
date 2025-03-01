<?php

namespace Database\Factories;

use App\Models\BoatModel;
use App\Models\Location;
use App\Models\Manufacturer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Boat>
 */
class BoatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $model = BoatModel::inRandomOrder()->first();

        return [
            'is_new' => $this->faker->boolean,
            'description' => $this->faker->paragraph,
            'boat_type' => $this->faker->randomElement(['sailing', 'motor']),
            'engine_number' => $this->faker->numberBetween(1, 4),
            'price' => $this->faker->numberBetween(50000, 500000),
            'year' => $this->faker->numberBetween(1900, 2025),
            'length' => $this->faker->randomFloat(2, 10, 100),
            'boat_model_id' => $model,
            'location_id' => Location::factory(),
        ];
    }
}
