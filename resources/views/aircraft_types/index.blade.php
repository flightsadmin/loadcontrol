@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card mt-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Aircraft Types</h4>
                    <a href="{{ route('aircraft_types.create') }}"
                        class="btn btn-primary btn-sm bi-plus-lg float-end mt-0"> Add New Aircraft Type</a>
                </div>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach ($aircraftTypes as $aircraftType)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $aircraftType->aircraft_type }}
                                        @if ($aircraftType->airline)
                                            <span class="ms-2">Airline: {{ $aircraftType->airline->name }}</span>
                                        @else
                                            <span class="ms-2">Airline: Not Assigned</span>
                                        @endif
                                    </strong>
                                    <p class="mb-1">Manufacturer: {{ $aircraftType->manufacturer }}</p>
                                    <p class="mb-1">Max Zero Fuel Weight: {{ $aircraftType->max_zero_fuel_weight }} kg</p>
                                    <p class="mb-1">Max Takeoff Weight: {{ $aircraftType->max_takeoff_weight }} kg</p>
                                    <p class="mb-1">Max Landing Weight: {{ $aircraftType->max_landing_weight }} kg</p>
                                    <p class="mb-1">Max Fuel Weight: {{ $aircraftType->max_fuel_weight }} kg</p>
                                </div>
                                <div class="d-flex">
                                    <a href="{{ route('aircraft_types.show', $aircraftType->id) }}"
                                        class="btn btn-warning btn-sm me-2 bi-eye"> View</a>
                                    <a href="{{ route('aircraft_types.edit', $aircraftType->id) }}"
                                        class="btn btn-primary btn-sm me-2 bi-pencil-square"> Edit</a>
                                    <form action="{{ route('aircraft_types.destroy', $aircraftType->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm bi-trash-fill"> Delete</button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
