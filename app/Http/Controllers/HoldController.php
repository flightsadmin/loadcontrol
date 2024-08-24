<?php

namespace App\Http\Controllers;

use App\Models\Hold;
use App\Models\Registration;
use Illuminate\Http\Request;

class HoldController extends Controller
{
    // Show the form for creating a new hold
    public function create($registration_id)
    {
        $registration = Registration::findOrFail($registration_id);
        return view('hold.create', compact('registration'));
    }

    // Store a newly created hold in storage
    public function store(Request $request, $registration_id)
    {
        $validated = $request->validate([
            'hold_no' => 'required|string|max:255',
            'fwd' => 'required|numeric',
            'aft' => 'required|numeric',
            'restrictions' => 'nullable|string',
        ]);

        $validated['registration_id'] = $registration_id;

        Hold::create($validated);

        return redirect()->route('registrations.show', $registration_id)->with('success', 'Hold created successfully.');
    }

    // Show the form for editing the specified hold
    public function edit($id)
    {
        $hold = Hold::findOrFail($id);
        return view('hold.edit', compact('hold'));
    }

    // Update the specified hold in storage
    public function update(Request $request, $id)
    {
        $hold = Hold::findOrFail($id);

        $validated = $request->validate([
            'hold_no' => 'required|string|max:255',
            'fwd' => 'required|numeric',
            'aft' => 'required|numeric',
            'restrictions' => 'nullable|string',
        ]);

        $hold->update($validated);

        return redirect()->route('registrations.show', $hold->registration_id)->with('success', 'Hold updated successfully.');
    }

    // Remove the specified hold from storage
    public function destroy($id)
    {
        $hold = Hold::findOrFail($id);
        $hold->delete();

        return redirect()->route('registrations.show', $hold->registration_id)->with('success', 'Hold deleted successfully.');
    }
}
