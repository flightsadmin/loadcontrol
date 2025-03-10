<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\FuelFigure;
use Illuminate\Http\Request;

class FuelFigureController extends Controller
{
    public function index(Flight $flight)
    {
        $fuelFigure = $flight->fuelFigure;

        return view('fuel_figures.index', compact('fuelFigure', 'flight'));
    }

    public function create(Flight $flight)
    {
        $fuelFigure = $flight->fuelFigure;

        $maxDeckCrew = $flight->registration->aircraftType->deck_crew;
        $maxCabinCrew = $flight->registration->aircraftType->cabin_crew;

        $crewOptions = [];
        for ($deck = 2; $deck <= $maxDeckCrew; $deck++) {
            for ($cabin = 1; $cabin <= $maxCabinCrew; $cabin++) {
                $crewOptions[] = $deck.'/'.$cabin;
            }
        }

        return view('fuel_figures.edit', compact('fuelFigure', 'flight', 'crewOptions'));
    }

    public function store(Request $request, Flight $flight)
    {
        $request->validate([
            'block_fuel' => 'required|numeric',
            'taxi_fuel' => 'required|numeric',
            'trip_fuel' => 'required|numeric',
            'crew' => 'required|string',
            'pantry' => 'required|string',
        ]);

        FuelFigure::updateOrCreate(
            ['flight_id' => $flight->id],
            [
                'block_fuel' => $request->block_fuel,
                'taxi_fuel' => $request->taxi_fuel,
                'trip_fuel' => $request->trip_fuel,
                'crew' => $request->crew,
                'pantry' => $request->pantry,
            ]
        );

        return redirect()->route('flights.show', [
            'flight' => $flight->id,
        ])->with('success', 'Fuel updated successfully.');
    }

    public function destroy(FuelFigure $fuelFigure)
    {
        $fuelFigure->delete();

        return redirect()->route('flights.show', [
            'flight' => $fuelFigure->flight->id,
        ])->with('success', 'Fuel updated successfully.');
    }
}
