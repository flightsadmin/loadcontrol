<?php

namespace Database\Factories;

use App\Models\Hold;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Registration>
 */
class RegistrationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'registration' => strtoupper($this->faker->unique()->bothify('A7-???')),
            'empty_weight' => $this->faker->numberBetween(43000, 45000),
            'max_takeoff_weight' => $this->faker->numberBetween(62000, 65000),
            'fuel_capacity' => $this->faker->numberBetween(1500, 18000),
            'deck_crew' => $this->faker->numberBetween(2, 4),
            'cabin_crew' => $this->faker->numberBetween(0, 6),
            'passenger_zones' => $this->faker->numberBetween(3, 5),
            'cg_range_min' => $this->faker->numberBetween(20, 23),
            'cg_range_max' => $this->faker->numberBetween(30, 33),
        ];
    }
}