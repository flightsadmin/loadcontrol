<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cargo>
 */
class CargoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $flight = \App\Models\Flight::inRandomOrder()->first();
        $holds = $flight->registration->holds;

        return [
            'flight_id' => $flight->id,
            'hold_id' => $holds->random()->id,
            'type' => $this->faker->randomElement(['baggage', 'cargo', 'mail']),
            'pieces' => $this->faker->numberBetween(50, 500),
            'weight' => $this->faker->numberBetween(2000, 5000),
        ];
    }
}
