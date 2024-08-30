<?php

namespace App\Http\Controllers;

use App\Models\Hold;
use App\Models\Registration;
use Illuminate\Http\Request;

class HoldController extends Controller
{
    public function create(Registration $registration)
    {
        return view('hold.create', compact('registration'));
    }

    public function store(Request $request, $registration_id)
    {
        $validated = $request->validate([
            'hold_no' => 'required|string|max:255',
            'fwd' => 'required|numeric',
            'aft' => 'required|numeric',
            'max' => 'required|numeric',
            'restrictions' => 'nullable|string',
        ]);

        $validated['registration_id'] = $registration_id;

        Hold::create($validated);

        return redirect()->route('registrations.show', $registration_id)->with('success', 'Hold created successfully.');
    }
    
    public function edit($id)
    {
        $hold = Hold::findOrFail($id);
        return view('hold.edit', compact('hold'));
    }

    public function update(Request $request, $id)
    {
        $hold = Hold::findOrFail($id);

        $validated = $request->validate([
            'hold_no' => 'required|string|max:255',
            'fwd' => 'required|numeric',
            'aft' => 'required|numeric',
            'max' => 'required|numeric',
            'restrictions' => 'nullable|string',
        ]);

        $hold->update($validated);

        return redirect()->route('registrations.show', $hold->registration_id)->with('success', 'Hold updated successfully.');
    }

    public function destroy($id)
    {
        $hold = Hold::findOrFail($id);
        $hold->delete();

        return redirect()->route('registrations.show', $hold->registration_id)->with('success', 'Hold deleted successfully.');
    }
}
