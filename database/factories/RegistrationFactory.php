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
            'registration_number' => strtoupper($this->faker->unique()->bothify('A7-???')),
            'aircraft_type_id' => \App\Models\AircraftType::inRandomOrder()->first()->id,
            'basic_weight' => $this->faker->numberBetween(42000, 44000),
            'basic_index' => $this->faker->randomFloat(2, 50, 52),
        ];
    }
}
