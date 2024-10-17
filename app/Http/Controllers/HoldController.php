<?php

namespace App\Http\Controllers;

use App\Models\AircraftType;
use App\Models\Hold;
use Illuminate\Http\Request;

class HoldController extends Controller
{
    public function index(AircraftType $aircraftType)
    {
        $holds = $aircraftType->holds;

        return view('holds.index', compact('aircraftType', 'holds'));
    }

    public function create(AircraftType $aircraftType)
    {
        return view('holds.create', compact('aircraftType'));
    }

    public function store(Request $request, AircraftType $aircraftType)
    {
        $validated = $request->validate([
            'hold_no' => 'required|string',
            'fwd' => 'required|numeric',
            'aft' => 'nullable|numeric',
            'max' => 'nullable|numeric',
            'arm' => 'nullable|numeric',
            'index' => 'nullable|numeric',
        ]);

        $aircraftType->holds()->create($validated);

        return redirect()->route('aircraft_types.holds.index', $aircraftType)->with('success', 'Hold created successfully.');
    }

    public function show(Hold $hold)
    {
        $aircraftType = $hold->load('aircraftType');

        return view('holds.show', compact('hold', 'aircraftType'));
    }

    public function edit(Hold $hold)
    {
        $aircraftType = $hold->aircraftType;

        return view('holds.edit', compact('hold', 'aircraftType'));
    }

    public function update(Request $request, Hold $hold)
    {
        $validated = $request->validate([
            'hold_no' => 'required|string',
            'fwd' => 'required|numeric',
            'aft' => 'nullable|numeric',
            'max' => 'nullable|numeric',
            'arm' => 'nullable|numeric',
            'index' => 'nullable|numeric',
        ]);

        $hold->update($validated);

        return redirect()->route('aircraft_types.holds.index', $hold->aircraftType)->with('success', 'Hold updated successfully.');
    }

    public function destroy(Hold $hold)
    {
        $aircraftType = $hold->aircraftType;
        $hold->delete();

        return redirect()->route('aircraft_types.holds.index', $aircraftType)->with('success', 'Hold deleted successfully.');
    }
}
