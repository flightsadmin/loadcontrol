<?php

namespace App\Http\Controllers;

use App\Models\Flight;
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
        $basicWeight = $flight->registration->empty_weight;
        $fuelFigure = $flight->fuelFigure;

        if (!$basicWeight || !$fuelFigure) {
            return redirect()->back()->withErrors('Basic Weight or Fuel Figure not found for this flight.');
        }
        $totalPassengerWeight = $flight->passengers->sum(function ($passenger) {
            $weightPerPassenger = match ($passenger->type) {
                'male' => 88,
                'female' => 70,
                'child' => 35,
                'infant' => 10,
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
            $deckCrewWeight = $deckCrewCount * 88;
            $cabinCrewWeight = $cabinCrewCount * 70;

            $totalCrewWeight = $deckCrewWeight + $cabinCrewWeight;
        }

        $dryOperatingWeight = $flight->registration->empty_weight + $totalCrewWeight;

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
        $passengerDistribution = $passengers->groupBy('type')->map(function ($typeGroup) {
            return $typeGroup->sum('count');
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
        return redirect()->route('flights.show', [
            'flight' => $flight->id,
            'tab' => 'documents'
        ])->with('success', 'Loadsheet Generated successfully.');
    }

    public function show($id)
    {
        $loadsheet = Loadsheet::findOrFail($id);
        return view('loadsheets.show', compact('loadsheet'));
    }
}
