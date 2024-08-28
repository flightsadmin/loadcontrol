@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Load Sheet for Flight {{ $loadSheet->flight->flight_number }}</h1>
    
    <div class="mb-3">
        <h3>Flight Details</h3>
        <p><strong>Flight Number:</strong> {{ $loadSheet->flight->flight_number }}</p>
        <p><strong>Departure:</strong> {{ $loadSheet->flight->departure->format('dS, M Y') }}</p>
        <p><strong>Arrival:</strong> {{ $loadSheet->flight->arrival->format('dS, M Y') }}</p>
    </div>

    <div class="mb-3">
        <h3>Passenger Information</h3>
        @foreach($loadSheet->flight->passengers as $passenger)
            <p>{{ $passenger->type }}: {{ $passenger->count }} in zone {{ $passenger->zone }}</p>
        @endforeach
    </div>

    <div class="mb-3">
        <h3>Cargo Information</h3>
        @foreach($loadSheet->flight->cargos as $cargo)
            <p>{{ $cargo->description }}: {{ $cargo->weight }} kgs</p>
        @endforeach
    </div>

    <div class="mb-3">
        <h3>Fuel Information</h3>
        @if($loadSheet->flight->fuel)
            <p>Block Fuel: {{ $loadSheet->flight->fuel->block_fuel }} liters</p>
            <p>Taxi Fuel: {{ $loadSheet->flight->fuel->taxi_fuel }} liters</p>
            <p>Trip Fuel: {{ $loadSheet->flight->fuel->trip_fuel }} liters</p>
            <p>Crew: {{ $loadSheet->flight->fuel->crew }}</p>
            <p>Pantry: {{ $loadSheet->flight->fuel->pantry }}</p>
        @else
            <p>No fuel information available.</p>
        @endif
    </div>

    <div class="mb-3">
        <h3>Calculated Weights</h3>
        <p><strong>Total Cargo Weight:</strong> {{ $loadSheet->total_deadload_weight }} kgs</p>
        <p><strong>Total Passenger Weight:</strong> {{ $loadSheet->total_passengers_weight }} kgs</p>
        <p><strong>Total Fuel Weight:</strong> {{ $loadSheet->total_fuel_weight }} liters</p>
        <p><strong>Gross Weight:</strong> {{ $loadSheet->gross_weight }} kgs</p>
        <p><strong>Balance:</strong> {{ $loadSheet->balance }}</p>
    </div>

    <div class="mb-3">
        <h3>Additional Details</h3>
        <p>{{ $loadSheet->details }}</p>
    </div>
</div>
@endsection
