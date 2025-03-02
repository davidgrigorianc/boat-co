<?php

namespace Database\Factories;

use App\Models\Boat;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'boat_id' => Boat::factory(),
            'amount' => $this->faker->randomFloat(2, 1000, 100000),
            'status' => 'pending',
            'transaction_id' => $this->faker->uuid(),
            'payment_provider' => 'stripe',
        ];
    }
}
