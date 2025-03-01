<?php

namespace Database\Factories;

use App\Models\Boat;
use App\Models\Engine;
use Illuminate\Database\Eloquent\Factories\Factory;

class EngineFactory extends Factory
{
    protected $model = Engine::class;

    public function definition()
    {
        return [
            'boat_id' => Boat::factory(),
            'make' => $this->faker->word,
            'model' => $this->faker->word,
            'type' => $this->faker->randomElement(['Inboard', 'Outboard']),
            'hours' => $this->faker->numberBetween(0, 5000),
            'power' => $this->faker->numberBetween(100, 1000),
            'fuel_type' => $this->faker->randomElement(['Diesel', 'Petrol', 'Electric']),
            'drive_type' => $this->faker->randomElement(['Pod Drive', 'Air Propeller','Direct Drive', null]),
        ];
    }

    public function createMultipleEnginesForBoat($boat, $num){
        for ($i = 0; $i < $num; $i++) {
            $this->create([
                'boat_id' => $boat->id,
            ]);
        }
    }
}
