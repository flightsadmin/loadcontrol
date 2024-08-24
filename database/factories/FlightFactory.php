<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Flight>
 */
class FlightFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'flight_number' => $this->faker->unique()->bothify('QR-###'),
            'departure' => $this->faker->dateTimeBetween('+1 day', '+1 month'),
            'arrival' => $this->faker->dateTimeBetween('+1 day', '+1 month'),
            'registration_id' => \App\Models\Registration::inRandomOrder()->first()->id,
        ];
    }
}
