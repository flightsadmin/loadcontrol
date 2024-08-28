<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\Loadsheet;
use Illuminate\Http\Request;

class LoadsheetController extends Controller
{
    public function create(Flight $flight)
    {
        return view('loadsheet.create', compact('flight'));
    }

    public function store(Request $request, Flight $flight)
    {
        Loadsheet::updateOrCreate(
            ['flight_id' => $flight->id],
            [
                'total_deadload_weight' => $this->calculateTotalDeadloadWeight($flight),
                'total_passengers_weight' => $this->calculateTotalPassengersWeight($flight),
                'total_fuel_weight' => $this->calculateTotalFuelWeight($flight),
                'gross_weight' => $this->calculateGrossWeight($flight),
                'balance' => $this->calculateBalance($flight),
            ]
        );
        return redirect()->route('flights.show', [
            'flight' => $flight->id,
            'tab' => 'documents'
        ])->with('success', 'Fuel updated successfully.');
    }

    private function calculateTotalDeadloadWeight(Flight $flight)
    {
        return $flight->cargos->sum('weight');
    }

    private function calculateTotalPassengersWeight(Flight $flight)
    {
        return $flight->passengers->sum(function ($passenger) {
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

    private function calculateTotalFuelWeight(Flight $flight)
    {
        $fuel = $flight->fuelFigure;
        if ($fuel) {
            return $fuel->block_fuel - $fuel->taxi_fuel;
        }
        return 0;
    }

    private function calculateGrossWeight(Flight $flight)
    {
        return 
            $this->calculateTotalWeight($flight) +
            $this->calculateTotalPassengersWeight($flight) +
            $this->calculateTotalFuelWeight($flight);
    }

    private function calculateBalance(Flight $flight)
    {
        return $this->calculateGrossWeight($flight) / 1000;
    }

    public function show(Loadsheet $loadsheet)
    {
        return view('loadsheet.show', compact('loadsheet'));
    }
}
