<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;

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
        $locales = ['en_US', 'ru_RU', 'fr_FR', 'de_DE', 'es_ES', 'it_IT'];
        $locale = $locales[array_rand($locales)];

        $faker = FakerFactory::create($locale);

        $countries = [
            'US' => ['name' => 'United States', 'cities' => ['New York', 'Los Angeles', 'Chicago', 'Houston', 'Phoenix']],
            'RU' => ['name' => 'Russia', 'cities' => ['Moscow', 'Saint Petersburg', 'Novosibirsk', 'Yekaterinburg', 'Nizhny Novgorod']],
            'DE' => ['name' => 'Germany', 'cities' => ['Berlin', 'Munich', 'Hamburg', 'Frankfurt', 'Cologne']],
            'FR' => ['name' => 'France', 'cities' => ['Paris', 'Marseille', 'Lyon', 'Toulouse', 'Nice']],
            'ES' => ['name' => 'Spain', 'cities' => ['Madrid', 'Barcelona', 'Valencia', 'Sevilla', 'Zaragoza']],
            'IT' => ['name' => 'Italy', 'cities' => ['Rome', 'Milan', 'Naples', 'Turin', 'Palermo']],
            'GB' => ['name' => 'United Kingdom', 'cities' => ['London', 'Manchester', 'Birmingham', 'Glasgow', 'Liverpool']],
            'JP' => ['name' => 'Japan', 'cities' => ['Tokyo', 'Osaka', 'Kyoto', 'Yokohama', 'Sapporo']],
            'IN' => ['name' => 'India', 'cities' => ['Delhi', 'Mumbai', 'Bangalore', 'Hyderabad', 'Chennai']],
            'BR' => ['name' => 'Brazil', 'cities' => ['Sao Paulo', 'Rio de Janeiro', 'Salvador', 'Brasilia', 'Fortaleza']],
            'CA' => ['name' => 'Canada', 'cities' => ['Toronto', 'Vancouver', 'Montreal', 'Calgary', 'Ottawa']],
            'AU' => ['name' => 'Australia', 'cities' => ['Sydney', 'Melbourne', 'Brisbane', 'Perth', 'Adelaide']],
            'MX' => ['name' => 'Mexico', 'cities' => ['Mexico City', 'Guadalajara', 'Monterrey', 'Cancun', 'Puebla']],
        ];

        $countryCode = array_rand($countries);
        $countryName = $countries[$countryCode]['name'];
        $cities = $countries[$countryCode]['cities'];
        $city = $cities[array_rand($cities)];

        return [
            'country' => $countryName,
            'city' => $city,
            'country_code' => $countryCode,
            'latitude' => $faker->latitude,
            'longitude' => $faker->longitude,
        ];
    }
}

