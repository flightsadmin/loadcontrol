@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card my-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>{{ $aircraftType->manufacturer }} - {{ $aircraftType->aircraft_type }}</h4>
                    <a href="{{ route('aircraft_types.envelopes.index', $aircraftType->id) }}"
                        class="btn btn-primary btn-sm mt-0 bi-database-fill-gear"> Manage Envelopes</a>
                    <a href="{{ route('aircraft_types.cabin_zones.index', $aircraftType->id) }}"
                        class="btn btn-primary btn-sm mt-0 bi-database-fill-gear"> Manage Cabin Zones</a>
                    <a href="{{ route('airlines.index') }}"
                        class="btn btn-primary btn-sm mt-0 bi-database-fill-gear"> Manage Airline</a>
                    <a href="{{ route('aircraft_types.holds.create', $aircraftType->id) }}"
                        class="btn btn-primary btn-sm mb-0 bi-plus-lg"> Add New Hold</a>
                    <a href="{{ route('aircraft_types.registrations.create', $aircraftType->id) }}"
                        class="btn btn-primary btn-sm mb-0 float-end bi-plus-lg"> Add New Registration</a>
                    <a href="{{ route('aircraft_types.index') }}"
                        class="btn btn-secondary btn-sm bi-backspace float-end mt-0"> Back</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4>Associated Registrations</h4>
                                    <span class="bi-card-list h5"></span>
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
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5>Holds</h5>
                                    <span class="bi-back h5"></span>
                                </div>
                                <ul class="list-group">
                                    @forelse ($aircraftType->holds as $hold)
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>{{ $hold->hold_no }}</strong>
                                                    <span class="text-muted">FWD: {{ $hold->fwd }}m, AFT: {{ $hold->aft }}m</span>
                                                    <div>Capacity: {{ $hold->max }}
                                                        <span class="text-muted">Index: {{ $hold->index ?? 'None' }} Arm:
                                                            {{ $hold->arm ?? 'None' }}</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <a href="{{ route('holds.edit', $hold->id) }}"
                                                        class="btn btn-link btn-sm me-2 bi-pencil-square"></a>
                                                    <form action="{{ route('holds.destroy', $hold->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-link text-danger btn-sm bi-trash"></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </li>
                                    @empty
                                        <p>No holds available for this registration.</p>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
