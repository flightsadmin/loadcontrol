<?php

namespace Database\Seeders;

use App\Models\FuelFigure;
use App\Models\Hold;
use App\Models\Passenger;
use App\Models\User;
use App\Models\Cargo;
use App\Models\Flight;
use App\Models\Registration;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Registration::factory(50)->create()->each(function ($registration) {
            $faker = Faker::create();
            $previousFwd = 0;
            for ($i = 1; $i <= 5; $i++) {
                $currentAft = $previousFwd + 20;
                Hold::create([
                    'registration_id' => $registration->id,
                    'hold_no' => 'H-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'fwd' => $previousFwd,
                    'aft' => $currentAft,
                    'restrictions' => $faker->optional()->randomElement(['No Avi', 'No HUM']),
                ]);
                $previousFwd = $currentAft;
            }
        });

        Flight::factory(50)->create()->each(function ($id) {
            FuelFigure::factory(1)->create([
                'flight_id' => $id
            ]);
            Passenger::factory(4)->create([
                'flight_id' => $id,
                'zone' => rand(1, $id->registration->passenger_zones)
            ]);
        });
        Cargo::factory(200)->create();
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
