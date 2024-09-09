<?php

namespace App\Http\Controllers;

use App\Models\AircraftType;
use App\Models\Airline;
use Illuminate\Http\Request;

class AircraftTypeController extends Controller
{
    public function index()
    {
        $aircraftTypes = AircraftType::with('airline')->get();
        return view('aircraft_types.index', compact('aircraftTypes'));
    }

    public function create()
    {
        $airlines = Airline::all();
        return view('aircraft_types.create', compact('airlines'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'aircraft_type' => 'required|string|max:255',
            'manufacturer' => 'required|string|max:255',
            'max_zero_fuel_weight' => 'required|integer',
            'max_takeoff_weight' => 'required|integer',
            'max_landing_weight' => 'required|integer',
            'deck_crew' => 'nullable|integer',
            'cabin_crew' => 'nullable|integer',
            'max_fuel_weight' => 'nullable|integer',
            'ref_sta' => 'nullable|numeric',
            'k_constant' => 'nullable|numeric',
            'c_constant' => 'nullable|numeric',
            'length_of_mac' => 'nullable|numeric',
            'lemac' => 'nullable|numeric',
            'airline_id' => 'required|exists:airlines,id',
        ]);

        AircraftType::create($validated);

        return redirect()->route('aircraft_types.index')->with('success', 'Aircraft type created successfully.');
    }

    public function show(AircraftType $aircraftType)
    {
        $aircraftType->load('registrations', 'cabinZones', 'fuelIndexes', 'holds');
        return view('aircraft_types.show', [
            'aircraftType' => $aircraftType,
            'registrations' => $aircraftType->registrations,
            'cabinZones' => $aircraftType->cabinZones,
            'fuelIndexes' => $aircraftType->fuelIndexes
        ]);
    }

    public function edit(AircraftType $aircraftType)
    {
        $airlines = Airline::all();
        return view('aircraft_types.edit', [
            'aircraftType' => $aircraftType,
            'airlines' => $airlines
        ]);
    }

    public function update(Request $request, AircraftType $aircraftType)
    {
        $validated = $request->validate([
            'aircraft_type' => 'required|string|max:255',
            'manufacturer' => 'required|string|max:255',
            'max_zero_fuel_weight' => 'required|integer',
            'max_takeoff_weight' => 'required|integer',
            'max_landing_weight' => 'required|integer',
            'deck_crew' => 'nullable|integer',
            'cabin_crew' => 'nullable|integer',
            'max_fuel_weight' => 'nullable|integer',
            'ref_sta' => 'nullable|numeric',
            'k_constant' => 'nullable|numeric',
            'c_constant' => 'nullable|numeric',
            'length_of_mac' => 'nullable|numeric',
            'lemac' => 'nullable|numeric',
            'airline_id' => 'required|exists:airlines,id',
        ]);

        $aircraftType->update($validated);

        return redirect()->route('aircraft_types.index')->with('success', 'Aircraft type updated successfully.');
    }

    public function destroy(AircraftType $aircraftType)
    {
        $aircraftType->delete();

        return redirect()->route('aircraft_types.index')->with('success', 'Aircraft type deleted successfully.');
    }
}
