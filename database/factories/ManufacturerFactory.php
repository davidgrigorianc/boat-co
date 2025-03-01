<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Manufacturer>
 */
class ManufacturerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $manufacturers = [
            'Oceano', 'Oysterr', 'Azimut', 'Tahity', 'SeaRay', 'Bayliner', 'Bertram',
            'Cobalt', 'Grady White', 'Regal', 'Chris Craft', 'Moomba', 'MasterCraft',
            'Rinker', 'Four Winns', 'Mako', 'Boston Whaler', 'Malibu', 'Lund', 'Tracker',
            'Sunseeker', 'Hatteras', 'Princess', 'Jeanneau', 'Beneteau', 'Fairline',
            'Hunter', 'Lagoon', 'Catalina', 'Tartan', 'Freedom', 'Silverton', 'MacGregor',
            'Sailfish', 'Key West', 'Crownline', 'Cigarette', 'Donzi', 'Chaparral', 'SeaPro',
            'Cushman', 'WoodenBoat', 'Pursuit', 'Albemarle', 'Caliber', 'Tidewater', 'Contender'
        ];

        return [
            'name' => $this->faker->unique()->randomElement($manufacturers),
        ];
    }
}
