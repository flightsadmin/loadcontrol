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
            'aircraft_type' => $this->faker->randomElement(['B737', 'A320', 'A330']),
            'manufacturer' => $this->faker->randomElement(['Boeing', 'Airbus']),
            'max_zero_fuel_weight' => $this->faker->numberBetween(46000, 50000),
            'max_takeoff_weight' => $this->faker->numberBetween(62000, 65000),
            'max_landing_weight' => $this->faker->numberBetween(55000, 58000),
            'deck_crew' => $this->faker->numberBetween(2, 4),
            'cabin_crew' => $this->faker->numberBetween(4, 8),
            'passenger_zones' => $this->faker->numberBetween(3, 5),
            'max_fuel_weight' => $this->faker->numberBetween(1500, 18000),
            'fwd_cg_limit' => $this->faker->numberBetween(20, 23),
            'aft_cg_limit' => $this->faker->numberBetween(30, 33),
        ];
    }
}
