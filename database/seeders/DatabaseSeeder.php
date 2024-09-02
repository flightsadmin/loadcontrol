<?php

namespace Database\Seeders;

use App\Models\CabinZone;
use App\Models\Hold;
use App\Models\User;
use App\Models\Cargo;
use App\Models\Flight;
use App\Models\Passenger;
use App\Models\FuelFigure;
use Faker\Factory as Faker;
use App\Models\AircraftType;
use App\Models\Registration;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        AircraftType::factory(3)->create()->each(function ($value) {
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
                    'restrictions' => $faker->optional()->randomElement(['No Avi', 'No HUM']),
                ]);
                $previousFwd = $currentAft;
            }
            Registration::factory(5)->create([
                'aircraft_type_id' => $value
            ]);
            CabinZone::factory(3)->create([
                'aircraft_type_id' => $value
            ]);
        });

        $data = [
            ['envelope_type' => 'ZFW', 'x' => 45, 'y' => 37],
            ['envelope_type' => 'ZFW', 'x' => 38, 'y' => 49],
            ['envelope_type' => 'ZFW', 'x' => 38, 'y' => 54],
            ['envelope_type' => 'ZFW', 'x' => 37, 'y' => 55],
            ['envelope_type' => 'ZFW', 'x' => 37, 'y' => 60],
            ['envelope_type' => 'ZFW', 'x' => 36.4, 'y' => 62.5],
            ['envelope_type' => 'ZFW', 'x' => 90, 'y' => 62.5],
            ['envelope_type' => 'ZFW', 'x' => 73, 'y' => 37],
            ['envelope_type' => 'ZFW', 'x' => 45, 'y' => 37],
            ['envelope_type' => 'TOW', 'x' => 43, 'y' => 37],
            ['envelope_type' => 'TOW', 'x' => 35, 'y' => 53],
            ['envelope_type' => 'TOW', 'x' => 35, 'y' => 63],
            ['envelope_type' => 'TOW', 'x' => 33, 'y' => 72],
            ['envelope_type' => 'TOW', 'x' => 36, 'y' => 73.5],
            ['envelope_type' => 'TOW', 'x' => 89, 'y' => 73.5],
            ['envelope_type' => 'TOW', 'x' => 90, 'y' => 72],
            ['envelope_type' => 'TOW', 'x' => 86, 'y' => 62],
            ['envelope_type' => 'TOW', 'x' => 67, 'y' => 43],
            ['envelope_type' => 'TOW', 'x' => 64, 'y' => 37],
            ['envelope_type' => 'TOW', 'x' => 43, 'y' => 37],
            ['envelope_type' => 'LDW', 'x' => 43, 'y' => 37],
            ['envelope_type' => 'LDW', 'x' => 35, 'y' => 53],
            ['envelope_type' => 'LDW', 'x' => 35, 'y' => 63],
            ['envelope_type' => 'LDW', 'x' => 34.5, 'y' => 66],
            ['envelope_type' => 'LDW', 'x' => 87.5, 'y' => 66],
            ['envelope_type' => 'LDW', 'x' => 86, 'y' => 62],
            ['envelope_type' => 'LDW', 'x' => 67, 'y' => 43],
            ['envelope_type' => 'LDW', 'x' => 64, 'y' => 37],
            ['envelope_type' => 'LDW', 'x' => 43, 'y' => 37]
        ];

        foreach ($data as $point) {
            AircraftType::all()->each(function ($aircraft) use ($point) {
                $aircraft->envelopes()->create($point);
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

        // Default App Setting
        foreach (config("admin.default") as $key => $value) {
            \App\Models\Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value],
            );
        }
    }
}
