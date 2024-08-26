<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Passenger>
 */
class PassengerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'flight_id' => \App\Models\Flight::inRandomOrder()->first()->id,
            'type' => $this->faker->randomElement(['male', 'female', 'child', 'infant']),
            'count' => $this->faker->numberBetween(1, 50),
            'zone' => $this->faker->numberBetween(1, 4),
        ];
    }
}
