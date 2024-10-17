<?php

namespace Database\Seeders;

use App\Models\Hold;
use App\Models\Route;
use App\Models\User;
use App\Models\Cargo;
use App\Models\Flight;
use App\Models\Airline;
use App\Models\Message;
use App\Models\CabinZone;
use App\Models\Passenger;
use App\Models\FuelFigure;
use Faker\Factory as Faker;
use App\Models\AircraftType;
use App\Models\Registration;
use App\Models\EmailTemplate;
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

        Airline::factory(1)->create()->each(function ($airline) {
            AircraftType::factory(1)->create([
                'airline_id' => $airline->id
            ])->each(function ($value) {
                $faker = Faker::create();
                $previousFwd = 0;

                // Holds
                foreach ([['number' => 1, 'max' => 3402, 'index' => -0.00642], ['number' => 3, 'max' => 2426, 'index' => +0.00401], ['number' => 4, 'max' => 2110, 'index' => +0.00741], ['number' => 5, 'max' => 1497, 'index' => +0.01048],] as $hold) {
                    $currentAft = $previousFwd + 25;
                    Hold::create([
                        'aircraft_type_id' => $value->id,
                        'hold_no' => $hold['number'],
                        'fwd' => $previousFwd,
                        'aft' => $currentAft,
                        'max' => $hold['max'],
                        'arm' => $faker->randomFloat(5, -0.0000001, 0.001),
                        'index' => $hold['index'],
                    ]);
                    $previousFwd = $currentAft;
                }

                // Cabin Zones
                foreach ([['name' => 'A', 'arm' => -6.971, 'index' => -0.00697], ['name' => 'B', 'arm' => +0.281, 'index' => +0.00028], ['name' => 'C', 'arm' => +8.271, 'index' => +0.00827],] as $zone) {
                    CabinZone::factory(1)->create([
                        'aircraft_type_id' => $value,
                        'zone_name' => $zone['name'],
                        'arm' => $zone['arm'],
                        'index' => $zone['index'],
                    ]);
                }

                // Registrations
                Registration::factory(5)->create([
                    'aircraft_type_id' => $value
                ]);
            });
            Route::factory(5)->create([
                'airline_id' => $airline->id
            ])->each(function ($route) use ($airline) {
                $route->emails()->updateOrCreate([
                    'email' => strtolower('wab@flightadmin.info'),
                    'airline_id' => $airline->id,
                ]);
            });
        });

        $envelope_data = [
            ['envelope_type' => 'TOW', 'weight' => 40600, 'index' => 39.02],
            ['envelope_type' => 'TOW', 'weight' => 45279, 'index' => 36.66],
            ['envelope_type' => 'TOW', 'weight' => 53000, 'index' => 33.43],
            ['envelope_type' => 'TOW', 'weight' => 63000, 'index' => 34.52],
            ['envelope_type' => 'TOW', 'weight' => 72000, 'index' => 31.50],
            ['envelope_type' => 'TOW', 'weight' => 73500, 'index' => 37.16],
            ['envelope_type' => 'TOW', 'weight' => 79000, 'index' => 62.28],
            ['envelope_type' => 'TOW', 'weight' => 79000, 'index' => 80.83],
            ['envelope_type' => 'TOW', 'weight' => 74708, 'index' => 87.90],
            ['envelope_type' => 'TOW', 'weight' => 73326, 'index' => 90.18],
            ['envelope_type' => 'TOW', 'weight' => 67400, 'index' => 86.45],
            ['envelope_type' => 'TOW', 'weight' => 51000, 'index' => 70.21],
            ['envelope_type' => 'TOW', 'weight' => 50000, 'index' => 69.22],
            ['envelope_type' => 'TOW', 'weight' => 47038, 'index' => 65.36],
            ['envelope_type' => 'TOW', 'weight' => 45249, 'index' => 60.62],
            ['envelope_type' => 'TOW', 'weight' => 42735, 'index' => 59.56],
            ['envelope_type' => 'TOW', 'weight' => 40600, 'index' => 56.62],

            ['envelope_type' => 'ZFW', 'weight' => 40600, 'index' => 40.70],
            ['envelope_type' => 'ZFW', 'weight' => 43941, 'index' => 39.02],
            ['envelope_type' => 'ZFW', 'weight' => 48658, 'index' => 37.05],
            ['envelope_type' => 'ZFW', 'weight' => 53398, 'index' => 37.56],
            ['envelope_type' => 'ZFW', 'weight' => 53872, 'index' => 37.56],
            ['envelope_type' => 'ZFW', 'weight' => 54346, 'index' => 37.43],
            ['envelope_type' => 'ZFW', 'weight' => 55611, 'index' => 37.01],
            ['envelope_type' => 'ZFW', 'weight' => 60143, 'index' => 37.50],
            ['envelope_type' => 'ZFW', 'weight' => 64300, 'index' => 36.11],
            ['envelope_type' => 'ZFW', 'weight' => 64300, 'index' => 83.40],
            ['envelope_type' => 'ZFW', 'weight' => 50080, 'index' => 69.31],
            ['envelope_type' => 'ZFW', 'weight' => 49606, 'index' => 69.84],
            ['envelope_type' => 'ZFW', 'weight' => 49132, 'index' => 68.10],
            ['envelope_type' => 'ZFW', 'weight' => 47049, 'index' => 65.39],
            ['envelope_type' => 'ZFW', 'weight' => 45340, 'index' => 60.86],
            ['envelope_type' => 'ZFW', 'weight' => 44866, 'index' => 61.39],
            ['envelope_type' => 'ZFW', 'weight' => 44392, 'index' => 60.26],
            ['envelope_type' => 'ZFW', 'weight' => 42970, 'index' => 59.66],
            ['envelope_type' => 'ZFW', 'weight' => 42022, 'index' => 58.80],
            ['envelope_type' => 'ZFW', 'weight' => 40600, 'index' => 58.20],
        ];

        foreach ($envelope_data as $point) {
            AircraftType::all()->each(function ($aircraft) use ($point) {
                $aircraft->envelopes()->create($point);
            });
        }

        $fuel_data = [
            ['weight' => 0001, 'index' => +0.00],
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
        foreach ($fuel_data as $fuel) {
            AircraftType::all()->each(function ($aircraft) use ($fuel) {
                $aircraft->fuelIndexes()->create($fuel);
            });
        }

        Flight::factory(50)->create()->each(function ($id_no) {
            FuelFigure::factory(1)->create([
                'flight_id' => $id_no
            ]);
            Message::factory(2)->create([
                'user_id' => User::inRandomOrder()->first()->id,
                'flight_id' => $id_no->id,
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
        EmailTemplate::insertOrIgnore([
            [
                'name' => 'loadsheet_released',
                'subject' => 'Loadsheet for {{flight_no}} Released',
                'body' => 'Loadsheet for {{flight_no}} Released by {{user_name}}.
                            Same is attached for your reference<br>
                            Incase of any clarification please contact Admin <br>',
            ],
            [
                'name' => 'user_confirmation',
                'subject' => 'Welcome onboard {{app_name}}',
                'body' => 'Welcome onboard {{app_name}}.<br>Click on {{app_url}} to login and change your password<br>',
            ]
        ]);
    }
}
