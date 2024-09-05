<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use Illuminate\Http\Request;

class AirlineController extends Controller
{
    public function create()
    {
        return view('airlines.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'iata_code' => 'required|string|max:3',
            'base' => 'required|string|max:255',
            'base_iata_code' => 'required|string|max:3',
            'settings.crew.deck_crew_weight' => 'required|numeric|min:0',
            'settings.crew.cabin_crew_weight' => 'required|numeric|min:0',
            'settings.passenger_weights.male' => 'required|numeric|min:0',
            'settings.passenger_weights.female' => 'required|numeric|min:0',
            'settings.passenger_weights.child' => 'required|numeric|min:0',
            'settings.passenger_weights.infant' => 'required|numeric|min:0',
        ]);
        Airline::updateOrCreate(
            ['iata_code' => $request->input('iata_code')],

            $validated
        );

        return redirect()->route('airlines.index')->with('success', 'Airline created successfully.');
    }

    public function edit(Airline $airline)
    {
        return view('airlines.edit', compact('airline'));
    }

    public function update(Request $request, Airline $airline)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'iata_code' => 'required|string|max:3',
            'base' => 'required|string|max:255',
            'base_iata_code' => 'required|string|max:3',
            'settings.crew.deck_crew_weight' => 'required|numeric|min:0',
            'settings.crew.cabin_crew_weight' => 'required|numeric|min:0',
            'settings.passenger_weights.male' => 'required|numeric|min:0',
            'settings.passenger_weights.female' => 'required|numeric|min:0',
            'settings.passenger_weights.child' => 'required|numeric|min:0',
            'settings.passenger_weights.infant' => 'required|numeric|min:0',
        ]);

        $airline->update($validated);

        return redirect()->route('airlines.index')->with('success', 'Airline updated successfully.');
    }

    public function index()
    {
        $airlines = Airline::all();
        return view('airlines.index', compact('airlines'));
    }

    public function show(Airline $airline)
    {
        return view('airlines.show', compact('airline'));
    }

    public function destroy(Airline $airline)
    {
        $airline->delete();
        return redirect()->route('airlines.index')->with('success', 'Airline deleted successfully.');
    }
}
