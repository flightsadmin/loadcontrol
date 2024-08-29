@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="mt-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">
                    <a href="{{ route('registrations.index') }}" class="text-decoration-none">
                        {{ $registration->registration }}
                    </a>
                </h4>
                <div>
                    <a href="{{ route('registrations.edit', $registration->id) }}" class="btn btn-warning btn-sm bi-pencil-square"> Edit Registration</a>
                    <form action="{{ route('registrations.destroy', $registration->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm bi-trash-fill"> Delete Registration</button>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="list-group col-md-6">
                    <div class="list-group-item"><strong>Max Takeoff Weight:</strong> {{ $registration->max_takeoff_weight }} kg</div>
                    <div class="list-group-item"><strong>Empty Weight:</strong> {{ $registration->basic_weight }} kg</div>
                    <div class="list-group-item"><strong>Fuel Capacity:</strong> {{ $registration->fuel_capacity }}</div>
                    <div class="list-group-item"><strong>CG Range:</strong> {{ $registration->cg_range_min }} -
                        {{ $registration->cg_range_max }}</div>
                </div>
                <ul class="list-group col-md-6">
                    @forelse ($registration->holds as $hold)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $hold->hold_no }}</strong>
                                    <span class="text-muted">FWD: {{ $hold->fwd }}m, AFT: {{ $hold->aft }}m</span>
                                    <div>Restrictions: {{ $hold->restrictions ?? 'None' }}</div>
                                </div>
                                <div>
                                    <a href="{{ route('holds.edit', $hold->id) }}" class="btn btn-link btn-sm me-2 bi-pencil-square"></a>
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
            <a href="{{ route('registrations.holds.create', $registration->id) }}" class="btn btn-primary btn-sm float-end mt-4 bi-plus-lg">
                Add New Hold</a>
        </div>
    </div>
@endsection
