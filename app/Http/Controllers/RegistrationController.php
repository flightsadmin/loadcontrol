<?php

namespace App\Http\Controllers;

use App\Models\Hold;
use App\Models\AircraftType;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index()
    {
        $registrations = Registration::with('holds')->simplePaginate(10);
        return view('registration.index', compact('registrations'));
    }

    public function create(AircraftType $aircraftType)
    {
        return view('registration.create', compact('aircraftType'));
    }

    public function store(Request $request, AircraftType $aircraftType)
    {
        $validated = $request->validate([
            'registration_number' => 'required|string',
            'basic_weight' => 'required|numeric',
            'basic_index' => 'required|numeric',
        ]);
        $validated['aircraft_type_id'] = $aircraftType->id;

        Registration::create($validated);

        return redirect()->route('aircraft_types.show', $aircraftType->id)->with('success', 'Registration created successfully.');
    }

    public function show($aircraft_type, $registration)
    {
        $registration = Registration::with('holds')->findOrFail($registration);
        $holds = Hold::where('registration_id', $registration->id)->get();
        return view('registration.show', compact('registration', 'holds'));
    }

    public function edit(AircraftType $aircraftType, Registration $registration)
    {
        return view('registration.edit', compact('aircraftType', 'registration'));
    }

    public function update(Request $request, AircraftType $aircraftType, Registration $registration)
    {
        $validated = $request->validate([
            'registration_number' => 'required|string',
            'basic_weight' => 'required|numeric',
            'basic_index' => 'required|numeric',
        ]);

        $registration->update($validated);

        return redirect()->route('aircraft_types.show', $aircraftType->id)->with('success', 'Registration updated successfully.');
    }

    public function destroy(AircraftType $aircraftType, Registration $registration)
    {
        $registration->delete();
        return redirect()->route('aircraft_types.show',  $aircraftType->id)->with('success', 'Registration deleted successfully.');
    }
}
