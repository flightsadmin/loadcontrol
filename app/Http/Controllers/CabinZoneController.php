<?php

namespace App\Http\Controllers;

use App\Models\CabinZone;
use App\Models\AircraftType;
use Illuminate\Http\Request;

class CabinZoneController extends Controller
{
    public function index(AircraftType $aircraftType)
    {
        $cabinZones = $aircraftType->cabinZones;
        return view('cabin_zones.index', compact('cabinZones', 'aircraftType'));
    }

    public function create(AircraftType $aircraftType)
    {
        return view('cabin_zones.create', compact('aircraftType'));
    }

    public function store(Request $request, AircraftType $aircraftType)
    {
        $validated = $request->validate([
            'zone_name' => 'required|string',
            'fwd' => 'required|numeric',
            'aft' => 'required|numeric',
            'max_capacity' => 'required|numeric',
            'index' => 'nullable|string',
        ]);

        $aircraftType->cabinZones()->create($validated);

        return redirect()->route('aircraft_types.cabin_zones.index', $aircraftType)
            ->with('success', 'Cabin Zone created successfully.');
    }

    public function edit(CabinZone $cabinZone)
    {
        return view('cabin_zones.edit', compact('cabinZone'));
    }

    public function update(Request $request, CabinZone $cabinZone)
    {
        $validated = $request->validate([
            'zone_name' => 'required|string',
            'fwd' => 'required|numeric',
            'aft' => 'required|numeric',
            'max_capacity' => 'required|numeric',
            'index' => 'nullable|string',
        ]);

        $cabinZone->update($validated);

        return redirect()->route('aircraft_types.cabin_zones.index', $cabinZone->aircraftType)
            ->with('success', 'Cabin Zone updated successfully.');
    }

    public function destroy(CabinZone $cabinZone)
    {
        $aircraftType = $cabinZone->aircraftType;
        $cabinZone->delete();

        return redirect()->route('aircraft_types.cabin_zones.index', $aircraftType)
            ->with('success', 'Cabin Zone deleted successfully.');
    }
}
