@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Loadsheet for Flight ID: {{ $loadsheet->flight_id }}</h1>

        <div class="card">
            <div class="card-header">
                Loadsheet Details
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">Total Traffic Load</dt>
                    <dd class="col-sm-8">{{ $loadsheet->total_traffic_load }} kg</dd>

                    <dt class="col-sm-4">Dry Operating Weight</dt>
                    <dd class="col-sm-8">{{ $loadsheet->dry_operating_weight }} kg</dd>

                    <dt class="col-sm-4">Zero Fuel Weight Actual</dt>
                    <dd class="col-sm-8">{{ $loadsheet->zero_fuel_weight_actual }} kg</dd>

                    <dt class="col-sm-4">Takeoff Fuel</dt>
                    <dd class="col-sm-8">{{ $loadsheet->take_off_fuel }} kg</dd>

                    <dt class="col-sm-4">Takeoff Weight Actual</dt>
                    <dd class="col-sm-8">{{ $loadsheet->take_off_weight_actual }} kg</dd>

                    <dt class="col-sm-4">Trip Fuel</dt>
                    <dd class="col-sm-8">{{ $loadsheet->trip_fuel }} kg</dd>

                    <dt class="col-sm-4">Landing Weight Actual</dt>
                    <dd class="col-sm-8">{{ $loadsheet->landing_weight_actual }} kg</dd>

                    <dt class="col-sm-4">Compartment Loads</dt>
                    <dd class="col-sm-8">
                        @foreach (json_decode($loadsheet->compartment_loads, true) as $compartment => $weight)
                            {{ ucfirst($compartment) }}: {{ $weight }} kg<br>
                        @endforeach
                    </dd>

                    <dt class="col-sm-4">Passenger Distribution</dt>
                    <dd class="col-sm-8">
                        @foreach (json_decode($loadsheet->passenger_distribution, true) as $type => $count)
                            {{ ucfirst($type) }}: {{ $count }}<br>
                        @endforeach
                    </dd>
                </dl>
            </div>
        </div>
    </div>
@endsection
