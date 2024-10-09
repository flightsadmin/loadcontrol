<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use App\Models\Flight;
use App\Models\Registration;
use App\Models\Route;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function index(Request $request)
    {
        $query = Flight::query();
        if ($request->has('date') && $request->date) {
            $date = \Carbon\Carbon::parse($request->date)->format('Y-m-d');
            $query->whereDate('departure', $date);
            session(['selectedDate' => $date]);
        }
        $flights = $query->with('registration')->orderBy('departure')->simplePaginate();

        return view('flight.index', compact('flights'));
    }

    public function create()
    {
        $registrations = Registration::all();
        $airlines = Airline::all();
        $routes = Route::all();
        return view('flight.create', compact('registrations', 'airlines', 'routes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'flight_number' => 'required|string',
            'registration_id' => 'required|exists:registrations,id',
            'airline_id' => 'required|exists:airlines,id',
            'route_id' => 'required|exists:routes,id',
            'departure' => 'required|date',
            'arrival' => 'required|date',
        ]);

        $flight = Flight::create($validated);

        return redirect()->route('flights.show', $flight->id)->with('success', 'Flight created successfully!');
    }

    public function show(Flight $flight, Request $request)
    {
        $flight->load('registration.aircraftType.holds', 'cargos');
        if ($request->has('tab')) {
            session(['activeTab' => $request->input('tab')]);
        }
        $activeTab = session('activeTab', 'flight');
        return view('flight.index', compact('flight', 'activeTab'));
    }

    public function edit(Flight $flight)
    {
        $registrations = Registration::all();
        $airlines = Airline::all();
        $routes = Route::all();
        return view('flight.edit', compact('flight', 'registrations', 'airlines', 'routes'));
    }

    public function update(Request $request, Flight $flight)
    {
        $validated = $request->validate([
            'flight_number' => 'required|string',
            'registration_id' => 'required|exists:registrations,id',
            'airline_id' => 'required|exists:airlines,id',
            'route_id' => 'required|exists:routes,id',
            'departure' => 'required|date',
            'arrival' => 'required|date',
        ]);
        $originalRegistrationId = $flight->registration_id;

        $flight->update($validated);

        if ((int) $flight->registration_id !== (int) $originalRegistrationId) {
            foreach ($flight->cargos as $cargo) {
                $cargo->hold_id = null;
                $cargo->save();
            }
        }

        return redirect()->route('flights.show', $flight->id)->with('success', 'Flight updated successfully!');
    }

    public function destroy(Flight $flight)
    {
        $flight->delete();
        return redirect()->route('flights.index')->with('success', 'Flight deleted successfully!');
    }
}
