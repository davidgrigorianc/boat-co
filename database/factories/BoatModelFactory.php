<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BoatModel>
 */
class BoatModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $models = [
            $this->faker->numberBetween(1, 1000) . $this->faker->randomLetter(),
            $this->faker->numberBetween(1, 1000) . strtoupper($this->faker->randomLetter()) . strtoupper($this->faker->randomLetter()),
            $this->faker->numberBetween(1, 1000) . strtoupper($this->faker->randomLetter()),
            $this->faker->numberBetween(1, 1000),
        ];

        return [
            'name' => $this->faker->randomElement($models),
        ];
    }
}
