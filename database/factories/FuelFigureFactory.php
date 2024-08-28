<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FuelFigure>
 */
class FuelFigureFactory extends Factory
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
            'block_fuel' => $this->faker->numberBetween(8000, 18000),
            'taxi_fuel' => 200,
            'trip_fuel' => $this->faker->numberBetween(7000, 12000),
            'crew' => $this->faker->randomElement(['2/4', '2/5', '3/4']),
            'pantry' => $this->faker->randomElement(['A', 'B', 'C']),
        ];
    }
}
