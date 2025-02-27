@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card my-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('aircraft_types.index') }}"
                        class="h5 m-0">{{ $aircraftType->manufacturer }} - {{ $aircraftType->aircraft_type }}</a>
                    <a href="{{ route('aircraft_types.envelopes.index', $aircraftType->id) }}"
                        class="btn btn-primary btn-sm mt-0 bi-database-fill-gear"> Manage Envelopes</a>
                    <a href="{{ route('aircraft_types.cabin_zones.index', $aircraftType->id) }}"
                        class="btn btn-primary btn-sm mt-0 bi-database-fill-gear"> Manage Cabin Zones</a>
                    <a href="{{ route('airlines') }}"
                        class="btn btn-primary btn-sm mt-0 bi-database-fill-gear"> Manage Airline</a>
                    <a href="{{ route('aircraft_types.holds.create', $aircraftType->id) }}"
                        class="btn btn-primary btn-sm mb-0 bi-plus-lg"> Add New Hold</a>
                    <a href="{{ route('aircraft_types.registrations.create', $aircraftType->id) }}"
                        class="btn btn-primary btn-sm mb-0 float-end bi-plus-lg"> Add New Registration</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="fw-bold text-decoration-underline">Associated Registrations</h4>
                                    <span class="mb-0 bi-card-list h5"></span>
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
                                <div>
                                    <livewire:crew :aircraftTypeId="$aircraftType->id" />
                                    <livewire:cabin-crew-seating :aircraftTypeId="$aircraftType->id" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="fw-bold text-decoration-underline">Holds</h5>
                                    <span class="mb-0 bi-back h5"></span>
                                </div>
                                <ul class="list-group mb-4">
                                    @forelse ($aircraftType->holds as $hold)
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>{{ $hold->hold_no }}</strong>
                                                    <span class="text-muted">FWD: {{ $hold->fwd }}m, AFT: {{ $hold->aft }}m</span>
                                                    <div>Capacity: {{ $hold->max }}
                                                        <span class="text-muted">
                                                            Index: {{ $hold->index ?? 'Nil' }}
                                                            Arm: {{ $hold->arm ?? 'Nil' }}
                                                        </span>
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
                                <div>
                                    <livewire:pantry :aircraftTypeId="$aircraftType->id" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
