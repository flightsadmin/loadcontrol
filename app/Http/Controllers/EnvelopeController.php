<?php

namespace App\Http\Controllers;

use App\Models\Envelope;
use App\Models\Registration;
use Illuminate\Http\Request;

class EnvelopeController extends Controller
{
    // Display a listing of envelopes for a specific registration
    public function index(Registration $registration)
    {
        $envelopes = $registration->envelopes;
        return view('envelopes.index', compact('envelopes', 'registration'));
    }

    // Show the form for creating a new envelope
    public function create(Registration $registration)
    {
        return view('envelopes.create', compact('registration'));
    }

    // Store a newly created envelope in the database
    public function store(Request $request, Registration $registration)
    {
        $validated = $request->validate([
            'envelope_type' => 'required|string|max:255',
            'x' => 'required|numeric',
            'y' => 'required|numeric',
        ]);

        $registration->envelopes()->create($validated);

        return redirect()->route('registrations.envelopes.index', $registration)->with('success', 'Envelope created successfully.');
    }

    // Show the form for editing an existing envelope
    public function edit(Registration $registration, Envelope $envelope)
    {
        return view('envelopes.edit', compact('registration', 'envelope'));
    }

    // Update the specified envelope in the database
    public function update(Request $request, Registration $registration, Envelope $envelope)
    {
        $validated = $request->validate([
            'envelope_type' => 'required|string|max:255',
            'x' => 'required|numeric',
            'y' => 'required|numeric',
        ]);

        $envelope->update($validated);

        return redirect()->route('registrations.envelopes.index', $registration)->with('success', 'Envelope updated successfully.');
    }

    // Delete the specified envelope from the database
    public function destroy(Registration $registration, Envelope $envelope)
    {
        $envelope->delete();

        return redirect()->route('registrations.envelopes.index', $registration)->with('success', 'Envelope deleted successfully.');
    }
}
