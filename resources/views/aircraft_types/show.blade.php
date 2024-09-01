@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card mt-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>{{ $aircraftType->aircraft_type }}</h4>
                    <a href="{{ route('aircraft_types.index') }}"
                        class="btn btn-secondary btn-sm bi-backspace float-end mt-0"> Back</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <ul class="list-group">
                            <li class="list-group-item"><strong>Manufacturer:</strong> {{ $aircraftType->manufacturer }}</li>
                            <li class="list-group-item"><strong>Max Zero Fuel Weight:</strong> {{ $aircraftType->max_zero_fuel_weight }}</li>
                            <li class="list-group-item"><strong>Max Takeoff Weight:</strong> {{ $aircraftType->max_takeoff_weight }}</li>
                            <li class="list-group-item"><strong>Max Landing Weight:</strong> {{ $aircraftType->max_landing_weight }}</li>
                            <li class="list-group-item"><strong>Deck Crew:</strong> {{ $aircraftType->deck_crew }}</li>
                            <li class="list-group-item"><strong>Cabin Crew:</strong> {{ $aircraftType->cabin_crew }}</li>
                            <li class="list-group-item"><strong>Passenger Zones:</strong> {{ $aircraftType->passenger_zones }}</li>
                            <li class="list-group-item"><strong>Max Fuel Weight:</strong> {{ $aircraftType->max_fuel_weight }}</li>
                            <li class="list-group-item"><strong>Fwd CG Limit:</strong> {{ $aircraftType->fwd_cg_limit }}</li>
                            <li class="list-group-item"><strong>Aft CG Limit:</strong> {{ $aircraftType->aft_cg_limit }}</li>
                        </ul>
                    </div>
                    <div class="col-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h4>Associated Registrations</h4>
                                        <a href="{{ route('aircraft_types.registrations.create', $aircraftType->id) }}"
                                            class="btn btn-primary btn-sm mb-2 float-end bi-plus-lg"> Add New Registration</a>
                                    </div>
                                    @if ($aircraftType->registrations->isEmpty())
                                        <p>No registrations found.</p>
                                    @else
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Registration Number</th>
                                                    <th>Basic Weight</th>
                                                    <th>Basic Index</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($aircraftType->registrations as $registration)
                                                    <tr>
                                                        <td>{{ $registration->registration_number }}</td>
                                                        <td>{{ $registration->basic_weight }}</td>
                                                        <td>{{ $registration->basic_index }}</td>
                                                        <td>
                                                            <a href="{{ route('registrations.show', $registration->id) }}"
                                                                class="btn btn-link btn-sm bi-eye text-info"></a>
                                                            <a href="{{ route('registrations.edit', $registration->id) }}"
                                                                class="btn btn-link btn-sm bi-pencil-square text-primary"></a>
                                                            <form
                                                                action="{{ route('registrations.destroy', $registration->id) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-link btn-sm bi-trash-fill text-danger"></button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
