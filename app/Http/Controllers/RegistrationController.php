<?php

namespace App\Http\Controllers;

use App\Models\AircraftType;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    // Show the form to create a new registration
    public function create(AircraftType $aircraftType)
    {
        return view('registrations.create', compact('aircraftType'));
    }

    // Store the new registration in the database
    public function store(Request $request, AircraftType $aircraftType)
    {
        $validated = $request->validate([
            'registration_number' => 'required|string',
            'basic_weight' => 'required|numeric',
            'basic_index' => 'required|numeric',
        ]);

        $registration = new Registration($validated);
        $registration->aircraft_type_id = $aircraftType->id;
        $registration->save();

        return redirect()->route('aircraft_types.show', $aircraftType->id)->with('success', 'Registration created successfully.');
    }

    // Show the specific registration details
    public function show(Registration $registration)
    {
        return view('registrations.show', compact('registration'));
    }

    // Show the form to edit a specific registration
    public function edit(Registration $registration)
    {
        return view('registrations.edit', compact('registration'));
    }

    // Update the specific registration in the database
    public function update(Request $request, Registration $registration)
    {
        $validated = $request->validate([
            'registration_number' => 'required|string',
            'basic_weight' => 'required|numeric',
            'basic_index' => 'required|numeric',
        ]);

        $registration->update($validated);

        return redirect()->route('aircraft_types.show', $registration->aircraft_type_id)->with('success', 'Registration updated successfully.');
    }

    // Delete the specific registration from the database
    public function destroy(Registration $registration)
    {
        $aircraftTypeId = $registration->aircraft_type_id;
        $registration->delete();

        return redirect()->route('aircraft_types.show', $aircraftTypeId)->with('success', 'Registration deleted successfully.');
    }
}
