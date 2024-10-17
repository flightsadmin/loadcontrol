<?php

namespace App\Http\Controllers;

use App\Models\AircraftType;
use App\Models\Envelope;
use Illuminate\Http\Request;

class EnvelopeController extends Controller
{
    public function index(AircraftType $aircraftType)
    {
        $envelopes = $aircraftType->envelopes;

        return view('envelopes.index', compact('aircraftType', 'envelopes'));
    }

    public function create(AircraftType $aircraftType)
    {
        return view('envelopes.create', compact('aircraftType'));
    }

    public function store(Request $request, AircraftType $aircraftType)
    {
        $request->validate([
            'envelope_type' => 'required|string|max:255',
            'index' => 'required|numeric',
            'weight' => 'required|numeric',
        ]);

        $aircraftType->envelopes()->create($request->all());

        return redirect()->route('aircraft_types.envelopes.index', $aircraftType->id)
            ->with('success', 'Envelope created successfully.');
    }

    public function edit(Envelope $envelope)
    {
        return view('envelopes.edit', compact('envelope'));
    }

    public function update(Request $request, Envelope $envelope)
    {
        $request->validate([
            'envelope_type' => 'required|string|max:255',
            'index' => 'required|numeric',
            'weight' => 'required|numeric',
        ]);

        $envelope->update($request->all());

        return redirect()->route('aircraft_types.envelopes.index', $envelope->aircraft_type_id)
            ->with('success', 'Envelope updated successfully.');
    }

    public function destroy(Envelope $envelope)
    {
        $aircraftTypeId = $envelope->aircraft_type_id;
        $envelope->delete();

        return redirect()->route('aircraft_types.envelopes.index', $aircraftTypeId)
            ->with('success', 'Envelope deleted successfully.');
    }
}
