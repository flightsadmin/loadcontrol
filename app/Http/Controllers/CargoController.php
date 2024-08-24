<?php
namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Flight;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    public function create(Flight $flight)
    {
        return view('cargo.create', compact('flight'));
    }

    public function store(Request $request, $flight_id)
    {
        $validated = $request->validate([
            'flight_id' => 'required|exists:flights,id',
            'hold_id' => 'nullable|exists:holds,id',
            'type' => 'required|string',
            'pieces' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0'
        ]);
        // $validated['flight_id'] = $flight_id;

        Cargo::create($validated);

        return redirect()->route('flights.show', $flight_id)->with('success', 'Cargo created successfully.');
    }

    public function edit(Cargo $cargo)
    {
        $flight = $cargo->flight;
        $holds = $flight->registration->holds;
        return view('cargo.edit', compact('cargo', 'flight', 'holds'));
    }

    public function update(Request $request, Cargo $cargo)
    {
        $request->validate([
            'flight_id' => 'required|exists:flights,id',
            'hold_id' => 'nullable|exists:holds,id',
            'type' => 'required|string',
            'pieces' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0'
        ]);

        $cargo->update($request->all());

        return redirect()->route('flights.show', $cargo->flight_id)->with('success', 'Cargo updated successfully.');
    }

    public function destroy(Cargo $cargo)
    {
        $cargo->delete();
        return redirect()->route('flights.show', $cargo->flight_id)->with('success', 'Cargo deleted successfully.');
    }
}
