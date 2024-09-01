<?php

namespace App\Http\Controllers;

use App\Models\AircraftType;
use Illuminate\Http\Request;

class AircraftTypeController extends Controller
{
    public function index()
    {
        $aircraftTypes = AircraftType::all();
        return view('aircraft_types.index', compact('aircraftTypes'));
    }

    public function create()
    {
        return view('aircraft_types.create');
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
            'passenger_zones' => 'nullable|integer',
            'max_fuel_weight' => 'nullable|integer',
            'fwd_cg_limit' => 'nullable|numeric',
            'aft_cg_limit' => 'nullable|numeric',
        ]);

        AircraftType::create($validated);

        return redirect()->route('aircraft_types.index')->with('success', 'Aircraft type created successfully.');
    }

    public function show(AircraftType $aircraftType)
    {
        $aircraftType->load('registrations');
        $holds = $aircraftType->holds;
        return view('aircraft_types.show', compact('aircraftType', 'holds'));
    }

    public function edit(AircraftType $aircraftType)
    {
        return view('aircraft_types.edit', compact('aircraftType'));
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
            'passenger_zones' => 'nullable|integer',
            'max_fuel_weight' => 'nullable|integer',
            'fwd_cg_limit' => 'nullable|numeric',
            'aft_cg_limit' => 'nullable|numeric',
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
