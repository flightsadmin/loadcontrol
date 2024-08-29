<?php

namespace App\Http\Controllers;

use App\Models\Hold;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index()
    {
        $registrations = Registration::with('holds')->simplePaginate(10);
        return view('registration.index', compact('registrations'));
    }

    public function create()
    {
        return view('registration.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'registration' => 'required',
            'max_takeoff_weight' => 'required|numeric',
            'basic_weight' => 'required|numeric',
            'deck_crew' => 'nullable|numeric',
            'cabin_crew' => 'nullable|numeric',
            'passenger_zones' => 'nullable|numeric',
            'fuel_capacity' => 'nullable|numeric',
            'cg_range_min' => 'nullable|numeric',
            'cg_range_max' => 'nullable|numeric',
        ]);

        $registration = Registration::create($request->all());
        return redirect()->route('registrations.show', $registration->id)->with('success', 'Registration updated successfully.');
    }

    public function show(Registration $registration)
    {
        $registration = Registration::with('holds')->findOrFail($registration->id);
        $holds = Hold::where('registration_id', $registration->id)->get();
        return view('registration.show', compact('registration', 'holds'));
    }

    public function edit(Registration $registration)
    {
        return view('registration.edit', compact('registration'));
    }

    public function update(Request $request, Registration $registration)
    {
        $request->validate([
            'registration' => 'required',
            'max_takeoff_weight' => 'required|numeric',
            'basic_weight' => 'required|numeric',
            'deck_crew' => 'nullable|numeric',
            'cabin_crew' => 'nullable|numeric',
            'passenger_zones' => 'nullable|numeric',
            'fuel_capacity' => 'nullable|numeric',
            'cg_range_min' => 'nullable|numeric',
            'cg_range_max' => 'nullable|numeric',
        ]);

        $registration->update($request->all());
        return redirect()->route('registrations.show', $registration->id)->with('success', 'Registration updated successfully.');
    }

    public function destroy(Registration $registration)
    {
        $registration->delete();
        return redirect()->route('registrations.index')->with('success', 'Registration deleted successfully.');
    }
}
