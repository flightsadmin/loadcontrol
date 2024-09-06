<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Airline>
 */
class AirlineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'iata_code' => strtoupper($this->faker->lexify('???')),
            'base' => $this->faker->city(),
            'base_iata_code' => strtoupper($this->faker->lexify('???')),
            'settings' => [
                'crew' => [
                    'deck_crew_weight' => 85,
                    'cabin_crew_weight' => 70,
                ],
                'passenger_weights' => [
                    'male' => 88,
                    'female' => 70,
                    'child' => 35,
                    'infant' => 0,
                ],
            ],
        ];
    }
}
