<?php

namespace App\Http\Controllers;

use \App\Models\FuelIndex;
use App\Models\Flight;
use App\Models\Loadsheet;

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
        $cabinZones = $flight->registration->aircraftType->cabinZones;

        if (!$basicWeight || !$fuelFigure) {
            return redirect()->back()->withErrors('Basic Weight or Fuel Figure not found for this flight.');
        }

        // Calculate weights
        $totalPassengerWeight = $this->calculatePassengerWeight($passengers);
        $totalDeadloadWeight = $deadloads->sum('weight');
        $totalCrewWeight = $this->calculateCrewWeight($fuelFigure->crew);
        $pantryWeight = $this->calculatePantryWeight($fuelFigure->pantry);

        // Operating weights
        $dryOperatingWeight = $basicWeight + $totalCrewWeight + $pantryWeight;
        $zeroFuelWeightActual = $dryOperatingWeight + $totalPassengerWeight + $totalDeadloadWeight;

        $blockFuel = $fuelFigure->block_fuel ?? 0;
        $taxiFuel = $fuelFigure->taxi_fuel ?? 0;
        $tripFuel = $fuelFigure->trip_fuel ?? 0;

        $takeOffWeightActual = $zeroFuelWeightActual + $blockFuel - $taxiFuel;
        $landingWeightActual = $takeOffWeightActual - $tripFuel;

        // Calculate compartment loads
        $compartmentLoads = $this->calculateCompartmentLoads($deadloads);

        // Calculate passenger index by cabin zone
        $passengerIndexByZone = $cabinZones->map(function ($zone) use ($passengers) {
            $zonePassengers = $passengers->filter(fn($passenger) => $passenger->zone === $zone->zone_name);
            $totalWeight = $this->calculatePassengerWeight($zonePassengers);
            $indexPerKg = $zone->index ?? 0;

            return [
                'zone_name' => $zone->zone_name,
                'weight' => $totalWeight,
                'index' => $totalWeight * $indexPerKg
            ];
        })->sortBy('zone_name')->values()->toArray();

        // Format passenger distribution and index by zone
        $passengerDistribution = $passengers->groupBy('type')->mapWithKeys(function ($paxGroup, $type) {
            return [$type => $paxGroup->sum('count')];
        })->toArray();

        $formattedPassengerDistribution = [
            'pax' => [
                'male' => $passengerDistribution['male'] ?? 0,
                'female' => $passengerDistribution['female'] ?? 0,
                'child' => $passengerDistribution['child'] ?? 0,
                'infant' => $passengerDistribution['infant'] ?? 0,
            ],
            'zones' => $passengerIndexByZone
        ];

        // Store loadsheet
        Loadsheet::updateOrCreate(
            ['flight_id' => $flight->id],
            [
                'total_traffic_load' => $totalPassengerWeight + $totalDeadloadWeight,
                'dry_operating_weight' => $dryOperatingWeight,
                'zero_fuel_weight_actual' => $zeroFuelWeightActual,
                'take_off_fuel' => $blockFuel - $taxiFuel,
                'take_off_weight_actual' => $takeOffWeightActual,
                'trip_fuel' => $tripFuel,
                'landing_weight_actual' => $landingWeightActual,
                'compartment_loads' => $compartmentLoads,
                'passenger_distribution' => json_encode($formattedPassengerDistribution),
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

        $zfwEnvelope = $envelopes->get('ZFW', collect())->map(fn($env) => $env->only(['x', 'y']))->toArray();
        $towEnvelope = $envelopes->get('TOW', collect())->map(fn($env) => $env->only(['x', 'y']))->toArray();
        $ldwEnvelope = $envelopes->get('LDW', collect())->map(fn($env) => $env->only(['x', 'y']))->toArray();

        $basicIndex = $flight->registration->basic_index;
        $paxIndex = array_sum(array_column(json_decode($flight->loadsheet->passenger_distribution, true)['zones'], 'index'));
        $cargoIndex = array_sum(array_column(json_decode($flight->loadsheet->compartment_loads, true), 'index'));
        $toFuelIndex = FuelIndex::getFuelIndex(
            $flight->fuelFigure->block_fuel - $flight->fuelFigure->taxi_fuel,
            $flight->registration->aircraftType->id
        )->index;
        $ldfuelIndex = FuelIndex::getFuelIndex(
            $flight->fuelFigure->block_fuel - $flight->fuelFigure->trip_fuel,
            $flight->registration->aircraftType->id
        )->index;
        $lizfw = $basicIndex + $paxIndex + $cargoIndex;
        $litow = $lizfw + $toFuelIndex;
        $lildw = $litow + $ldfuelIndex;
        
        return view('loadsheet.trim', compact('flight', 'zfwEnvelope', 'towEnvelope', 'ldwEnvelope', 'lizfw', 'litow', 'lildw'));
    }

    private function calculatePassengerWeight($passengers)
    {
        return $passengers->sum(function ($passenger) {
            $weightPerPassenger = match ($passenger->type) {
                'male' => 88,
                'female' => 70,
                'child' => 35,
                'infant' => 10,
                default => 84,
            };

            return $passenger->count * $weightPerPassenger;
        });
    }

    private function calculateCrewWeight($crewData)
    {
        $standardCrew = [85, 75];
        return collect(explode('/', $crewData ?? ''))->map(function ($crew, $index) use ($standardCrew) {
            $crewCount = (int) $crew;
            return $crewCount * ($standardCrew[$index] ?? 0);
        })->sum();
    }

    private function calculatePantryWeight($pantrySetting)
    {
        return $pantrySetting === 'A' ? 500 : 45;
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
                'weight' => $totalWeight,
                'index' => $index
            ];
        })->sortBy('hold_no')->values()->toJson();
    }
}
