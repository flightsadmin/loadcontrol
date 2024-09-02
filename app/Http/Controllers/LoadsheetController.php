<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\Envelope;
use App\Models\Loadsheet;

class LoadsheetController extends Controller
{
    public function create(Flight $flight)
    {
        $this->calculateAndStoreLoadsheet($flight);

        return redirect()->route('loadsheets.show', ['id' => $flight])
            ->with('success', 'Loadsheet created and updated successfully.');
    }

    public function store(Flight $flight)
    {
        $passengers = $flight->passengers;
        $deadloads = $flight->cargos->whereNotNull('hold_id');
        $basicWeight = $flight->registration->basic_weight;
        $fuelFigure = $flight->fuelFigure;

        if (!$basicWeight || !$fuelFigure) {
            return redirect()->back()->withErrors('Basic Weight or Fuel Figure not found for this flight.');
        }
        $totalPassengerWeight = $flight->passengers->sum(function ($passenger) {
            $weightPerPassenger = match ($passenger->type) {
                'male' => 88,
                'female' => 70,
                'child' => 35,
                'infant' => 0,
                default => 84,
            };

            return $passenger->count * $weightPerPassenger;
        });

        $totalDeadloadWeight = $deadloads->sum('weight');

        $totalCrewWeight = 0;
        if ($fuelFigure && $fuelFigure->crew) {
            $crewCounts = explode('/', $fuelFigure->crew);
            $deckCrewCount = (int) ($crewCounts[0] ?? 0);
            $cabinCrewCount = (int) ($crewCounts[1] ?? 0);
            $deckCrewWeight = $deckCrewCount * 85;
            $cabinCrewWeight = $cabinCrewCount * 75;

            $totalCrewWeight = $deckCrewWeight + $cabinCrewWeight;
        }

        $dryOperatingWeight = $flight->registration->basic_weight + $totalCrewWeight;

        $takeOffFuel = $fuelFigure->block_fuel ?? 0;
        $taxiFuel = $fuelFigure->taxi_fuel ?? 0;
        $tripFuel = $fuelFigure->trip_fuel ?? 0;

        $zeroFuelWeightActual = $dryOperatingWeight + $totalPassengerWeight + $totalDeadloadWeight;
        $takeOffWeightActual = $zeroFuelWeightActual + $takeOffFuel - $taxiFuel;
        $landingWeightActual = $takeOffWeightActual - $tripFuel;

        // Calculate total deadload weight by hold
        $compartmentLoads = $deadloads->groupBy('hold_id')->map(function ($typeGroup) {
            return $typeGroup->sum('weight');
        })->toJson();

        // Calculate passenger distribution by gender
        $passengerDistribution = $passengers->groupBy('type')->map(function ($paxGroup) {
            return $paxGroup->sum('count');
        })->toArray();

        $passengerDistribution = json_encode(array_merge([
            'male' => 0,
            'female' => 0,
            'child' => 0,
            'infant' => 0,
        ], $passengerDistribution));

        Loadsheet::updateOrCreate(
            ['flight_id' => $flight->id],
            [
                'total_traffic_load' => $totalPassengerWeight + $totalDeadloadWeight,
                'dry_operating_weight' => $dryOperatingWeight,
                'zero_fuel_weight_actual' => $zeroFuelWeightActual,
                'take_off_fuel' => $takeOffFuel - $taxiFuel,
                'take_off_weight_actual' => $takeOffWeightActual,
                'trip_fuel' => $tripFuel,
                'landing_weight_actual' => $landingWeightActual,
                'compartment_loads' => $compartmentLoads,
                'passenger_distribution' => $passengerDistribution,
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
        
        return view('loadsheet.trim', compact('flight', 'zfwEnvelope', 'towEnvelope', 'ldwEnvelope'));
    }
}
