<?php

namespace App\Http\Controllers;

use App\Models\Envelope;
use App\Models\AircraftType;
use Illuminate\Http\Request;

class EnvelopeController extends Controller
{
    public function index(AircraftType $aircraftType)
    {
        $envelopes = $aircraftType->envelopes;
        return view('envelopes.index', compact('envelopes', 'aircraftType'));
    }

    public function create(AircraftType $aircraftType)
    {
        return view('envelopes.create', compact('aircraftType'));
    }

    public function store(Request $request, AircraftType $aircraftType)
    {
        $validated = $request->validate([
            'envelope_type' => 'required|string|max:255',
            'x' => 'required|numeric',
            'y' => 'required|numeric',
        ]);

        $aircraftType->envelopes()->create($validated);

        return redirect()->route('aircraft_types.envelopes.index', $aircraftType->id)
            ->with('success', 'Envelope created successfully!');
    }

    public function show(AircraftType $aircraftType, Envelope $envelope)
    {
        return view('envelopes.show', compact('envelope', 'aircraftType'));
    }

    public function edit(AircraftType $aircraftType, Envelope $envelope)
    {
        return view('envelopes.edit', compact('envelope', 'aircraftType'));
    }

    public function update(Request $request, AircraftType $aircraftType, Envelope $envelope)
    {
        $validated = $request->validate([
            'envelope_type' => 'required|string|max:255',
            'x' => 'required|numeric',
            'y' => 'required|numeric',
        ]);

        $envelope->update($validated);

        return redirect()->route('aircraft_types.envelopes.show', [$aircraftType->id, $envelope->id])
            ->with('success', 'Envelope updated successfully!');
    }

    public function destroy(AircraftType $aircraftType, Envelope $envelope)
    {
        $envelope->delete();

        return redirect()->route('aircraft_types.envelopes.index', $aircraftType->id)
            ->with('success', 'Envelope deleted successfully!');
    }
}
