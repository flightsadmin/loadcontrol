<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Flight;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    public function index(Flight $flight)
    {
        $cargos = $flight->cargos->all();

        return view('cargo.index', compact('flight', 'cargos'));
    }

    public function create(Flight $flight)
    {
        return view('cargo.create', compact('flight'));
    }

    public function store(Request $request, $flight_id)
    {
        $validated = $request->validate([
            'hold_id' => 'nullable|exists:holds,id',
            'type' => 'required|string',
            'pieces' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
        ]);
        $validated['flight_id'] = $flight_id;

        Cargo::create($validated);

        return redirect()->route('flights.show', [
            'flight' => $flight_id,
            'tab' => 'cargo',
        ])->with('success', 'Cargo updated successfully.');
    }

    public function edit(Cargo $cargo)
    {
        $flight = $cargo->flight;
        $holds = $flight->registration->aircraftType->holds;

        return view('cargo.edit', compact('cargo', 'flight', 'holds'));
    }

    public function update(Request $request, Cargo $cargo)
    {
        $request->validate([
            'flight_id' => 'required|exists:flights,id',
            'hold_id' => 'nullable|exists:holds,id',
            'type' => 'required|string',
            'pieces' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
        ]);

        $cargo->update($request->all());

        return redirect()->route('flights.show', [
            'flight' => $cargo->flight_id,
            'tab' => 'cargo',
        ])->with('success', 'Cargo updated successfully.');
    }

    public function updateHold(Request $request, Cargo $cargo)
    {
        $cargo->hold_id = $request->input('hold_id');
        $cargo->save();

        return response()->json(['success' => true]);
    }

    public function destroy(Cargo $cargo)
    {
        $cargo->delete();

        return redirect()->route('flights.show', [
            'flight' => $cargo->flight_id,
            'tab' => 'cargo',
        ])->with('success', 'Cargo Deleted successfully.');
    }
}
