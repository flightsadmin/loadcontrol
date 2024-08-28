<?php

namespace App\Http\Controllers;

use App\Models\Hold;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index()
    {
        $registrations = Registration::with('holds')->simplePaginate();
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
            'empty_weight' => 'required|numeric',
            'fuel_capacity' => 'nullable|numeric',
            'cg_range_min' => 'nullable|numeric',
            'cg_range_max' => 'nullable|numeric',
        ]);

        Registration::create($request->all());
        return redirect()->route('registrations.index');
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
            'empty_weight' => 'required|numeric',
            'fuel_capacity' => 'nullable|numeric',
            'cg_range_min' => 'nullable|numeric',
            'cg_range_max' => 'nullable|numeric',
        ]);

        $registration->update($request->all());
        return redirect()->route('registrations.index');
    }

    public function destroy(Registration $registration)
    {
        $registration->delete();
        return redirect()->route('registrations.index');
    }
}
