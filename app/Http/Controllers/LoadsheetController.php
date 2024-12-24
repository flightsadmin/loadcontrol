<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\EmailTemplate;
use App\Models\Flight;
use App\Models\FuelIndex;
use App\Models\Loadsheet;
use App\Notifications\DynamicNotification;
use Dompdf\Dompdf;
use Dompdf\Options;
use Exception;

class LoadsheetController extends Controller
{
    public function create(Flight $flight)
    {
        return redirect()->route('loadsheets.show', ['id' => $flight->id])
            ->with('success', 'Loadsheet created and updated successfully.');
    }

    public function store(Flight $flight)
    {
        $passengers = $flight->passengers;
        $deadloads = $flight->cargos->whereNotNull('hold_id');
        $basicWeight = $flight->registration->basic_weight;
        $fuelFigure = $flight->fuelFigure;
        $aircraftType = $flight->registration->aircraftType;

        if (! $basicWeight || ! $fuelFigure) {
            return redirect()->back()->withErrors('Basic Weight or Fuel Figure not found for this flight.');
        }

        // Calculate weights
        $totalPassengerWeight = $this->calculatePassengerWeight($passengers, $flight);
        $totalDeadloadWeight = $deadloads->sum('weight');
        $totalCrewWeight = $this->calculateCrewWeightAndIndex($fuelFigure->crew, $flight)['total_crew_weight'];
        $totalCrewIndex = $this->calculateCrewWeightAndIndex($fuelFigure->crew, $flight)['total_crew_index'];
        $pantry = $this->calculatePantryWeightAndIndex($fuelFigure->pantry, $flight);

        // Operating weights
        $dryOperatingWeight = $basicWeight + $totalCrewWeight + $pantry['weight'];
        $zeroFuelWeightActual = $dryOperatingWeight + $totalPassengerWeight + $totalDeadloadWeight;

        $blockFuel = $fuelFigure->block_fuel ?? 0;
        $taxiFuel = $fuelFigure->taxi_fuel ?? 0;
        $tripFuel = $fuelFigure->trip_fuel ?? 0;

        $takeOffWeightActual = $zeroFuelWeightActual + $blockFuel - $taxiFuel;
        $landingWeightActual = $takeOffWeightActual - $tripFuel;

        // Calculate compartment loads
        $compartmentLoads = $this->calculateCompartmentLoads($deadloads);

        // Calculate passenger index by cabin zone
        $passengerIndexByZone = $aircraftType->cabinZones->map(function ($zone) use ($passengers, $flight) {
            $zonePassengers = $passengers->filter(fn ($passenger) => $passenger->zone === $zone->zone_name);
            $totalWeight = $this->calculatePassengerWeight($zonePassengers, $flight);
            $indexPerKg = $zone->index ?? 0;

            return [
                'zone_name' => $zone->zone_name,
                'weight' => $totalWeight,
                'index' => $totalWeight * $indexPerKg,
                'passenger_count' => $zonePassengers->reject(fn ($passenger) => $passenger->type === 'infant')->sum('count'),
            ];
        })->sortBy('zone_name')->values()->toArray();

        // Format passenger distribution by type
        $passengerDistribution = $passengers->groupBy('type')->mapWithKeys(function ($paxGroup, $type) {
            return [$type => $paxGroup->sum('count')];
        })->toArray();

        $deadloadDistribution = $deadloads->groupBy('type')->mapWithKeys(function ($cargoGroup, $type) {
            return [$type => $cargoGroup->sum('weight')];
        })->toArray();

        $formattedPassengerDistribution = [
            'pax_by_type' => [
                'male' => $passengerDistribution['male'] ?? 0,
                'female' => $passengerDistribution['female'] ?? 0,
                'child' => $passengerDistribution['child'] ?? 0,
                'infant' => $passengerDistribution['infant'] ?? 0,
            ],
            'zones_breakdown' => $passengerIndexByZone,
        ];

        $formattedDeadloadDistribution = [
            'deadload_by_type' => [
                'C' => $deadloadDistribution['cargo'] ?? 0,
                'M' => $deadloadDistribution['mail'] ?? 0,
                'B' => $deadloadDistribution['baggage'] ?? 0,
            ],
            'hold_breakdown' => $compartmentLoads,
        ];

        $finalValues = [
            'total_traffic_load' => $totalPassengerWeight + $totalDeadloadWeight,
            'dry_operating_weight' => $dryOperatingWeight,
            'zero_fuel_weight_actual' => $zeroFuelWeightActual,
            'take_off_fuel' => $blockFuel - $taxiFuel,
            'take_off_weight_actual' => $takeOffWeightActual,
            'trip_fuel' => $tripFuel,
            'taxi_fuel' => $taxiFuel,
            'landing_weight_actual' => $landingWeightActual,
            'basicIndex' => round($flight->registration->basic_index, 2),
            'pantryIndex' => round($pantry['index'], 2),
            'paxIndex' => array_sum(array_column($formattedPassengerDistribution['zones_breakdown'], 'index')),
            'cargoIndex' => array_sum(array_column($formattedDeadloadDistribution['hold_breakdown'], 'index')),
            'toFuelIndex' => round(FuelIndex::getFuelIndex(
                $fuelFigure->block_fuel - $fuelFigure->taxi_fuel,
                $aircraftType->id
            )->index, 2),
            'ldfuelIndex' => round(FuelIndex::getFuelIndex(
                $fuelFigure->block_fuel - $fuelFigure->trip_fuel,
                $aircraftType->id
            )->index, 2),
        ];

        $finalValues['doi'] = round($finalValues['basicIndex'] + $finalValues['pantryIndex'] + $totalCrewIndex, 2);
        $finalValues['dli'] = round($finalValues['basicIndex'] + $finalValues['pantryIndex'] + $finalValues['cargoIndex'] + $totalCrewIndex, 2);
        $finalValues['lizfw'] = round($finalValues['basicIndex'] + $finalValues['pantryIndex'] + $finalValues['paxIndex'] + $finalValues['cargoIndex'], 2);
        $finalValues['litow'] = round($finalValues['lizfw'] + $finalValues['toFuelIndex'], 2);
        $finalValues['lildw'] = round($finalValues['litow'] + $finalValues['ldfuelIndex'], 2);
        $finalValues['macZFW'] = round((($aircraftType->c_constant * ($finalValues['lizfw'] - $aircraftType->k_constant) / $zeroFuelWeightActual) + ($aircraftType->ref_sta - $aircraftType->lemac)) / ($aircraftType->length_of_mac / 100), 2);
        $finalValues['macTOW'] = round((($aircraftType->c_constant * ($finalValues['litow'] - $aircraftType->k_constant) / $takeOffWeightActual) + ($aircraftType->ref_sta - $aircraftType->lemac)) / ($aircraftType->length_of_mac / 100), 2);

        $finalValues = array_merge($finalValues, $formattedPassengerDistribution, $formattedDeadloadDistribution, $flight->airline->settings);

        // Store loadsheet
        Loadsheet::updateOrCreate(
            ['flight_id' => $flight->id],
            [
                'payload_distribution' => json_encode($finalValues),
            ]
        );

        return redirect()->route('flights.loadsheets.show', [
            'flight' => $flight->id,
            'loadsheet' => $flight->loadsheet->id,
        ])->with('success', 'Loadsheet Generated successfully.');
    }

    public function show(Flight $flight)
    {
        $flight = $flight->load('registration.aircraftType');
        $envelopes = $flight->registration->aircraftType->envelopes->groupBy('envelope_type');

        $chartValues = [];
        foreach (['ZFW', 'TOW', 'LDW'] as $key => $value) {
            $chartValues[strtolower($value).'Envelope'] = $envelopes->get($value, collect())->map(function ($env) {
                return [
                    'x' => $env['index'],
                    'y' => $env['weight'],
                ];
            })->toArray();
        }

        return view('loadsheet.trim', compact('flight', 'chartValues'));
    }

    private function calculatePassengerWeight($passengers, $flight)
    {
        return $passengers->sum(function ($passenger) use ($flight) {
            $weightPerPassenger = match ($passenger->type) {
                'male' => (int) $flight->airline->settings['passenger_weights']['male'] ?? 88,
                'female' => (int) $flight->airline->settings['passenger_weights']['female'] ?? 70,
                'child' => (int) $flight->airline->settings['passenger_weights']['child'] ?? 35,
                'infant' => (int) $flight->airline->settings['passenger_weights']['infant'] ?? 10,
                default => (int) $flight->airline->settings['passenger_weights']['default'] ?? 84,
            };

            return $passenger->count * $weightPerPassenger;
        });
    }

    private function distributeCabinCrew($crewCount, $crewDistributionData)
    {
        // Match the distribution based on the number of cabin crew
        $distribution = match ($crewCount) {
            1 => $crewDistributionData['crew_distribution']['1'],
            2 => $crewDistributionData['crew_distribution']['2'],
            3 => $crewDistributionData['crew_distribution']['3'],
            4 => $crewDistributionData['crew_distribution']['4'],
            5 => $crewDistributionData['crew_distribution']['5'],
            default => throw new Exception('Invalid cabin crew count')
        };

        // Assign distribution to cabin locations
        $cabinLocations = $crewDistributionData['cabin_crew'];
        foreach ($distribution as $index => $crewNumber) {
            $cabinLocations[$index]['max_number'] = $crewNumber;
        }
        $cabinLocations = array_filter($cabinLocations, function ($location) {
            return $location['max_number'] > 0;
        });

        return $cabinLocations;
    }

    private function calculateCrewWeightAndIndex($crewData, $flight)
    {
        $standardCrew = [
            'deck_crew_weight' => (int) $flight->airline->settings['crew']['deck_crew_weight'] ?? 85,
            'cabin_crew_weight' => (int) $flight->airline->settings['crew']['cabin_crew_weight'] ?? 75,
        ];

        [$deckCrewCount, $cabinCrewCount] = explode('/', $crewData ?? '0/0');
        $totalCrewWeight = ((int) $deckCrewCount * $standardCrew['deck_crew_weight']) + ((int) $cabinCrewCount * $standardCrew['cabin_crew_weight']);

        $cockpit = $flight->registration->aircraftType->settings['crew_data']['deck_crew'][0]; // Returns first set of deck crew TODO

        $deckCrewIndex = (int) $deckCrewCount * $standardCrew['deck_crew_weight'] * $cockpit['index_per_kg'];

        $cabinLocations = $this->distributeCabinCrew((int) $cabinCrewCount, $flight->registration->aircraftType->settings['crew_data']);

        $cabinCrewIndex = 0.0;
        foreach ($cabinLocations as $location) {
            $cabinCrewIndex += ($location['number_of_crew'] ?? 0) * $standardCrew['cabin_crew_weight'] * $location['index_per_kg'];
        }

        $totalCrewIndex = round($deckCrewIndex + $cabinCrewIndex, 4);

        return [
            'total_crew_weight' => $totalCrewWeight,
            'total_crew_index' => $totalCrewIndex,
        ];
    }

    private function calculatePantryWeightAndIndex($pantrySetting, $flight)
    {
        $pantries = $flight->registration->aircraftType->settings['pantries'] ?? [];
        $actualPantry = collect($pantries)->firstWhere('name', $pantrySetting);

        $weight = (int) ($actualPantry['weight'] ?? 0);
        $index = round($actualPantry['index'], 4) ?? 0.00;

        return [
            'weight' => $weight,
            'index' => $index,
        ];
    }

    private function calculateCompartmentLoads($deadloads)
    {
        return $deadloads->groupBy('hold_id')->map(function ($cargoGroup) {
            $totalWeight = $cargoGroup->sum('weight');
            $hold = $cargoGroup->first()->hold;
            $holdNo = $hold->hold_no;
            $weightPerKg = $hold->index ?? 0;

            $index = $totalWeight * $weightPerKg;

            return [
                'hold_no' => $holdNo,
                'pieces' => $cargoGroup->sum('pieces'),
                'weight' => $totalWeight,
                'index' => $index,
            ];
        })->sortBy('hold_no')->values()->toArray();
    }

    public function finalizeLoadsheet(Flight $flight)
    {
        $flight->loadsheet->increment('edition');
        $flight->loadsheet->final = true;
        $flight->loadsheet->user_id = auth()->user()->id;
        $flight->loadsheet->save();

        $user = $flight->loadsheet->user;
        $template = EmailTemplate::where('name', 'loadsheet_released')->firstOrFail();
        $data = [
            'flight_no' => $flight->flight_number,
            'user_name' => $user->name,
            'user_email' => $user->email,
        ];

        $recipients = Address::where('route_id', $flight->route->id)
            ->where('airline_id', $flight->airline_id)->get();

        $options = new Options;
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('enable_html5_parser', true);
        $pdf = new Dompdf($options);

        $pdf->loadHtml(view('flight.partials.loadsheet', compact('flight'))->render());
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
        $pdfData = $pdf->output();

        $filePath = storage_path('app/loadsheets/loadsheet edition '.$flight->loadsheet->edition.'.pdf');

        if (! file_exists(dirname($filePath))) {
            mkdir(dirname($filePath), 0755, true);
        }

        file_put_contents($filePath, $pdfData);

        foreach ($recipients as $email) {
            $email->notify((new DynamicNotification($data, $template, $filePath)));
        }

        return redirect()->route('flights.loadsheets.show', [
            'flight' => $flight->id,
            'loadsheet' => $flight->loadsheet->id,
        ])->with('success', 'Loadsheet Generated successfully.');
    }
}
