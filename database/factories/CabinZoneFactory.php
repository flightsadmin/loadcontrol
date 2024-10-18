<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CabinZone>
 */
class CabinZoneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'aircraft_type_id' => null,
            'zone_name' => $this->faker->citySuffix(),
            'max_capacity' => $this->faker->numberBetween(50, 70),
            'index' => $this->faker->randomFloat(5, -0.0000001, 0.001),
            'arm' => $this->faker->randomFloat(5, -0.0000001, 0.001),
        ];
    }
}
