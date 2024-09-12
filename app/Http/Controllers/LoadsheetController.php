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
        $totalPassengerWeight = $this->calculatePassengerWeight($passengers, $flight);
        $totalDeadloadWeight = $deadloads->sum('weight');
        $totalCrewWeight = $this->calculateCrewWeight($fuelFigure->crew, $flight);
        $pantryWeight = $this->calculatePantryWeightAndIndex($fuelFigure->pantry, $flight);

        // Operating weights
        $dryOperatingWeight = $basicWeight + $totalCrewWeight + $pantryWeight['weight'];
        $zeroFuelWeightActual = $dryOperatingWeight + $totalPassengerWeight + $totalDeadloadWeight;

        $blockFuel = $fuelFigure->block_fuel ?? 0;
        $taxiFuel = $fuelFigure->taxi_fuel ?? 0;
        $tripFuel = $fuelFigure->trip_fuel ?? 0;

        $takeOffWeightActual = $zeroFuelWeightActual + $blockFuel - $taxiFuel;
        $landingWeightActual = $takeOffWeightActual - $tripFuel;

        // Calculate compartment loads
        $compartmentLoads = $this->calculateCompartmentLoads($deadloads);

        // Calculate passenger index by cabin zone
        $passengerIndexByZone = $cabinZones->map(function ($zone) use ($passengers, $flight) {
            $zonePassengers = $passengers->filter(fn($passenger) => $passenger->zone === $zone->zone_name);
            $totalWeight = $this->calculatePassengerWeight($zonePassengers, $flight);
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

        $basicIndex = $flight->registration->basic_index;
        $pantryIndex = $this->calculatePantryWeightAndIndex($flight->fuelFigure->pantry, $flight)['index'];
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
        $type = $flight->registration->aircraftType;
        $lizfw = $basicIndex + $pantryIndex + $paxIndex + $cargoIndex;
        $litow = $lizfw + $toFuelIndex;
        $lildw = $litow + $ldfuelIndex;
        
        $macZFW = round((($type->c_constant * ($lizfw - $type->k_constant) / $flight->loadsheet->zero_fuel_weight_actual)
            + ($type->ref_sta - $type->lemac)) / ($type->length_of_mac / 100), 2);
        $macTOW = round((($type->c_constant * ($litow - $type->k_constant) / $flight->loadsheet->take_off_weight_actual)
            + ($type->ref_sta - $type->lemac)) / ($type->length_of_mac / 100), 2);

        return view('loadsheet.trim', compact('flight', 'zfwEnvelope', 'towEnvelope', 'lizfw', 'litow', 'lildw', 'macZFW', 'macTOW'));
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

    private function calculateCrewWeight($crewData, $flight)
    {
        $standardCrew = [
            "deck_crew_weight" => (int) $flight->airline->settings['crew']['deck_crew_weight'] ?? 85,
            "cabin_crew_weight" => (int) $flight->airline->settings['crew']['cabin_crew_weight'] ?? 75
        ];
        list($deckCrewCount, $cabinCrewCount) = explode('/', $crewData ?? '0/0');

        return ((int) $deckCrewCount * $standardCrew["deck_crew_weight"]) + ((int) $cabinCrewCount * $standardCrew["cabin_crew_weight"]);
    }


    private function calculatePantryWeightAndIndex($pantrySetting, $flight)
    {
        $pantries = $flight->registration->aircraftType->settings['pantries'] ?? [];
        $actualPantry = collect($pantries)->firstWhere('name', $pantrySetting);
        
        $weight = (int) ($actualPantry['weight'] ?? 0);
        $index = round($actualPantry['index'], 4) ?? 0.00;
        
        return [
            'weight' => $weight,
            'index' => $index
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
                'weight' => $totalWeight,
                'index' => $index
            ];
        })->sortBy('hold_no')->values()->toJson();
    }
}
