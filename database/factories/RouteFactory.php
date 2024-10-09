<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Route>
 */
class RouteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'origin' => $this->faker->randomElement(['DOH', 'JFK', 'LHR', 'NBO', 'MCT', 'KWI', 'SYD', 'JED', 'DXB', 'SIN']),
            'destination' => $this->faker->randomElement(['DOH', 'JFK', 'LHR', 'NBO', 'MCT', 'KWI', 'SYD', 'JED', 'DXB', 'SIN']),
            'flight_time' => '00:01:00',
        ];
    }
}
