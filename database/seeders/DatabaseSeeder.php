<?php

namespace Database\Seeders;

use App\Models\AircraftType;
use App\Models\Airline;
use App\Models\CabinZone;
use App\Models\Cargo;
use App\Models\Flight;
use App\Models\FuelFigure;
use App\Models\Hold;
use App\Models\Passenger;
use App\Models\Registration;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class
        ]);
        Airline::factory(3)->create()->each(function ($airline) {
            AircraftType::factory(1)->create([
                'airline_id' => $airline->id
            ])->each(function ($value) {
                $faker = Faker::create();
                $previousFwd = 0;
                for ($i = 1; $i <= 5; $i++) {
                    $currentAft = $previousFwd + 20;
                    Hold::create([
                        'aircraft_type_id' => $value->id,
                        'hold_no' => $i,
                        'fwd' => $previousFwd,
                        'aft' => $currentAft,
                        'max' => $faker->numberBetween(1400, 2300),
                        'arm' => $faker->randomFloat(5, -0.0000001, 0.001),
                        'index' => $faker->randomFloat(5, -0.0000001, 0.001),
                    ]);
                    $previousFwd = $currentAft;
                }

                Registration::factory(5)->create([
                    'aircraft_type_id' => $value
                ]);

                foreach (['A', 'B', 'C'] as $zone) {
                    CabinZone::factory(1)->create([
                        'aircraft_type_id' => $value,
                        'zone_name' => $zone
                    ]);
                }
            });
        });

        $data = [
            ['envelope_type' => 'TOW', 'x' => 39.02, 'y' => 40.600],
            ['envelope_type' => 'TOW', 'x' => 36.66, 'y' => 45.279],
            ['envelope_type' => 'TOW', 'x' => 33.43, 'y' => 53.000],
            ['envelope_type' => 'TOW', 'x' => 34.52, 'y' => 63.000],
            ['envelope_type' => 'TOW', 'x' => 31.50, 'y' => 72.000],
            ['envelope_type' => 'TOW', 'x' => 37.16, 'y' => 73.500],
            ['envelope_type' => 'TOW', 'x' => 62.28, 'y' => 79.000],
            ['envelope_type' => 'TOW', 'x' => 80.83, 'y' => 79.000],
            ['envelope_type' => 'TOW', 'x' => 87.90, 'y' => 74.708],
            ['envelope_type' => 'TOW', 'x' => 90.18, 'y' => 73.326],
            ['envelope_type' => 'TOW', 'x' => 86.45, 'y' => 67.400],
            ['envelope_type' => 'TOW', 'x' => 70.21, 'y' => 51.000],
            ['envelope_type' => 'TOW', 'x' => 69.22, 'y' => 50.000],
            ['envelope_type' => 'TOW', 'x' => 65.36, 'y' => 47.038],
            ['envelope_type' => 'TOW', 'x' => 60.62, 'y' => 45.249],
            ['envelope_type' => 'TOW', 'x' => 59.56, 'y' => 42.735],
            ['envelope_type' => 'TOW', 'x' => 56.62, 'y' => 40.600],

            ['envelope_type' => 'ZFW', 'x' => 40.70, 'y' => 40.600],
            ['envelope_type' => 'ZFW', 'x' => 39.02, 'y' => 43.941],
            ['envelope_type' => 'ZFW', 'x' => 37.05, 'y' => 48.658],
            ['envelope_type' => 'ZFW', 'x' => 37.56, 'y' => 53.398],
            ['envelope_type' => 'ZFW', 'x' => 37.56, 'y' => 53.872],
            ['envelope_type' => 'ZFW', 'x' => 37.43, 'y' => 54.346],
            ['envelope_type' => 'ZFW', 'x' => 37.01, 'y' => 55.611],
            ['envelope_type' => 'ZFW', 'x' => 37.50, 'y' => 60.143],
            ['envelope_type' => 'ZFW', 'x' => 36.11, 'y' => 64.300],
            ['envelope_type' => 'ZFW', 'x' => 83.40, 'y' => 64.300],
            ['envelope_type' => 'ZFW', 'x' => 69.31, 'y' => 50.080],
            ['envelope_type' => 'ZFW', 'x' => 69.84, 'y' => 49.606],
            ['envelope_type' => 'ZFW', 'x' => 68.10, 'y' => 49.132],
            ['envelope_type' => 'ZFW', 'x' => 65.39, 'y' => 47.049],
            ['envelope_type' => 'ZFW', 'x' => 60.86, 'y' => 45.340],
            ['envelope_type' => 'ZFW', 'x' => 61.39, 'y' => 44.866],
            ['envelope_type' => 'ZFW', 'x' => 60.26, 'y' => 44.392],
            ['envelope_type' => 'ZFW', 'x' => 59.66, 'y' => 42.970],
            ['envelope_type' => 'ZFW', 'x' => 58.80, 'y' => 42.022],
            ['envelope_type' => 'ZFW', 'x' => 58.20, 'y' => 40.600],
        ];

        foreach ($data as $point) {
            AircraftType::all()->each(function ($aircraft) use ($point) {
                $aircraft->envelopes()->create($point);
            });
        }

        $fuelData = [
            ['weight' => 1, 'index' => +0],
            ['weight' => 3500, 'index' => +0.99],
            ['weight' => 4000, 'index' => +0.47],
            ['weight' => 4500, 'index' => -0.01],
            ['weight' => 5000, 'index' => -0.48],
            ['weight' => 5500, 'index' => -0.91],
            ['weight' => 6000, 'index' => -1.32],
            ['weight' => 6500, 'index' => -1.7],
            ['weight' => 7000, 'index' => -2.06],
            ['weight' => 7500, 'index' => -2.39],
            ['weight' => 8000, 'index' => -2.71],
            ['weight' => 8500, 'index' => -2.99],
            ['weight' => 9000, 'index' => -3.16],
            ['weight' => 9500, 'index' => -3.19],
            ['weight' => 10000, 'index' => -3.05],
            ['weight' => 10500, 'index' => -2.8],
            ['weight' => 11000, 'index' => -2.44],
            ['weight' => 11500, 'index' => -1.96],
            ['weight' => 12000, 'index' => -1.4],
            ['weight' => 12500, 'index' => -1.6],
            ['weight' => 13000, 'index' => -2.23],
            ['weight' => 13500, 'index' => -2.94],
            ['weight' => 14000, 'index' => -3.7],
            ['weight' => 14500, 'index' => -4.48],
            ['weight' => 15000, 'index' => -5.26],
            ['weight' => 15500, 'index' => -6.04],
            ['weight' => 16000, 'index' => -6.83],
            ['weight' => 16500, 'index' => -7.61],
            ['weight' => 17000, 'index' => -8.39],
            ['weight' => 17500, 'index' => -9.17],
            ['weight' => 18000, 'index' => -9.96],
            ['weight' => 18500, 'index' => -10.83],
            ['weight' => 18632, 'index' => -11.08]
        ];
        foreach ($fuelData as $fuel) {
            AircraftType::all()->each(function ($aircraft) use ($fuel) {
                $aircraft->fuelIndexes()->create($fuel);
            });
        }

        Flight::factory(50)->create()->each(function ($id_no) {
            FuelFigure::factory(1)->create([
                'flight_id' => $id_no
            ]);
            Passenger::factory(1)->create([
                'flight_id' => $id_no,
                'zone' => $id_no->registration->aircraftType->cabinZones->random()->zone_name
            ]);
            Cargo::factory(5)->create([
                'flight_id' => $id_no,
                'hold_id' => null
            ]);
        });

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
