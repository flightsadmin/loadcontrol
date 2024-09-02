<?php

namespace App\Http\Controllers;

use App\Models\Passenger;
use App\Models\Flight;
use Illuminate\Http\Request;

class PassengerController extends Controller
{
    public function index(Flight $flight)
    {
        $passengers = $flight->passengers->groupBy('zone');
        return view('passengers.index', compact('flight', 'passengers'));
    }

    public function store(Request $request, Flight $flight)
    {
        $request->validate([
            'type' => 'required|in:male,female,child,infant',
            'count' => 'required|integer|min:0',
            'zone' => 'required|string',
        ]);
    
        $flight->passengers()->updateOrCreate(
            ['zone' => $request->zone, 'type' => $request->type],
            ['count' => $request->count]
        );
        return redirect()->route('flights.show', [
            'flight' => $flight->id,
            'tab' => 'passengers'
        ]);
    }

    public function destroy(Flight $flight, Passenger $passenger)
    {
        $passenger->delete();
        return redirect()->route('flights.passengers.index', $flight->id);
    }
}
