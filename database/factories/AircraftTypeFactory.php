<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AircraftType>
 */
class AircraftTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'airline_id' => null,
            'aircraft_type' => $this->faker->randomElement(['B737', 'A320', 'A330']),
            'manufacturer' => $this->faker->randomElement(['Boeing', 'Airbus']),
            'max_zero_fuel_weight' => 64300,
            'max_takeoff_weight' => 79000,
            'max_landing_weight' => 67400,
            'deck_crew' => $this->faker->numberBetween(2, 4),
            'cabin_crew' => $this->faker->numberBetween(4, 8),
            'config' => $this->faker->randomElement(['J04Y174', 'J04Y180', 'Y180']),
            'ref_sta' => 18.850,
            'k_constant' => 50,
            'c_constant' => 1000,
            'length_of_mac' => 4.194,
            'lemac' => 17.8015,
            'settings' => [
                'pantries' => [
                    [
                        'name' => 'A',
                        'index' => '1.59',
                        'weight' => '497',
                    ],
                    [
                        'name' => 'E',
                        'index' => '0.18',
                        'weight' => '45',
                    ],
                ],
                'crew_data' => [
                    "deck_crew" => [
                        [
                            'location' => 'Cockpit',
                            'max_number' => 4,
                            'arm' => -13.410,
                            "index_per_kg" => -0.01355
                        ]
                    ],
                    "cabin_crew" => [
                        [
                            "location" => "FWD of FWD door",
                            'max_number' => 2,
                            'arm' => -11.520,
                            "index_per_kg" => -0.01152
                        ],
                        [
                            "location" => "FWD of aft door RH",
                            'max_number' => 1,
                            'arm' => +12.991,
                            "index_per_kg" => -0.01299
                        ],
                        [
                            "location" => "FWD of aft door LH",
                            'max_number' => 1,
                            'arm' => +12.991,
                            "index_per_kg" => 0.01299
                        ],
                        [
                            "location" => "AFT of aft door",
                            'max_number' => 1,
                            'arm' => +13.665,
                            "index_per_kg" => 0.01366
                        ]
                    ],
                    "crew_distribution" => [
                        1 => [1, 0, 0, 0],
                        2 => [1, 1, 0, 0],
                        3 => [2, 1, 0, 0],
                        4 => [2, 1, 1, 0],
                        5 => [2, 1, 1, 1]
                    ]
                ],
            ],
        ];
    }
}
