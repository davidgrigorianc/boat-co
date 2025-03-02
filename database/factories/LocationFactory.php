<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Location>
 */
class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $countries = [
            'US' => ['name' => 'United States', 'cities' => [
                ['name' => 'New York', 'lat' => 40.7128, 'lng' => -74.0060],
                ['name' => 'Los Angeles', 'lat' => 34.0522, 'lng' => -118.2437],
                ['name' => 'Chicago', 'lat' => 41.8781, 'lng' => -87.6298],
                ['name' => 'Houston', 'lat' => 29.7604, 'lng' => -95.3698],
                ['name' => 'Phoenix', 'lat' => 33.4484, 'lng' => -112.0740],
            ]],
            'RU' => ['name' => 'Russia', 'cities' => [
                ['name' => 'Moscow', 'lat' => 55.7558, 'lng' => 37.6173],
                ['name' => 'Saint Petersburg', 'lat' => 59.9343, 'lng' => 30.3351],
                ['name' => 'Novosibirsk', 'lat' => 55.0084, 'lng' => 82.9357],
                ['name' => 'Yekaterinburg', 'lat' => 56.8389, 'lng' => 60.6057],
                ['name' => 'Nizhny Novgorod', 'lat' => 56.2965, 'lng' => 43.9361],
            ]],
            'DE' => ['name' => 'Germany', 'cities' => [
                ['name' => 'Berlin', 'lat' => 52.5200, 'lng' => 13.4050],
                ['name' => 'Munich', 'lat' => 48.1351, 'lng' => 11.5820],
                ['name' => 'Hamburg', 'lat' => 53.5511, 'lng' => 9.9937],
                ['name' => 'Frankfurt', 'lat' => 50.1109, 'lng' => 8.6821],
                ['name' => 'Cologne', 'lat' => 50.9375, 'lng' => 6.9603],
            ]],
        ];

        $countryCode = array_rand($countries);
        $country = $countries[$countryCode];
        $cityData = $country['cities'][array_rand($country['cities'])];

        return [
            'country' => $country['name'],
            'city' => $cityData['name'],
            'country_code' => $countryCode,
            'latitude' => $cityData['lat'],
            'longitude' => $cityData['lng'],
        ];
    }
}
