<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Cargo;
use App\Models\Flight;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function index()
    {
        $flights = Flight::with('registration')->simplePaginate();
        return view('flight.index', compact('flights'));
    }

    public function create()
    {
        $registrations = Registration::all();
        return view('flight.create', compact('registrations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'registration_id' => 'required|exists:registrations,id',
            'flight_number' => 'required|string',
            'origin' => 'required|string',
            'destination' => 'required|string',
            'airline' => 'required|string',
            'flight_type' => 'required|in:Domestic,International',
            'departure' => 'required',
            'arrival' => 'required',
        ]);

        $flight = Flight::create($validated);

        return redirect()->route('flights.show', $flight->id);
    }

    public function show(Flight $flight)
    {
        $flight->load('cargos', 'registration.holds');

        $fuelWeight = $flight->registration->fuel_capacity * 0.8;
        $totalWeight = $flight->registration->empty_weight + $fuelWeight;
        $totalCG = $flight->registration->cg_range_min;

        foreach ($flight->cargos as $cargo) {
            $totalWeight += $cargo->weight;
            $totalCG += $cargo->weight * $cargo->position;
        }

        if ($totalWeight > 0) {
            $totalCG = $totalCG / $totalWeight;
        }

        $flights = Flight::all();

        return view('flight.index', compact('flight', 'totalWeight', 'totalCG', 'flights'));
    }

    public function edit(Flight $flight)
    {
        $registrations = Registration::all();
        return view('flight.edit', compact('flight', 'registrations'));
    }

    public function update(Request $request, Flight $flight)
    {
        $validated = $request->validate([
            'registration_id' => 'required|exists:registrations,id',
            'flight_number' => 'required|string',
            'origin' => 'required|string',
            'destination' => 'required|string',
            'airline' => 'required|string',
            'flight_type' => 'required|in:Domestic,International',
            'departure' => 'required',
            'arrival' => 'required',
        ]);

        $flight->update($validated);

        return redirect()->route('flights.show', $flight->id);
    }

    public function destroy(Flight $flight)
    {
        $flight->delete();
        return redirect()->route('flights.index');
    }
}
