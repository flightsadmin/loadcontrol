@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="mt-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">
                    <a href="{{ route('aircraft_types.show', $registration->aircraft_type_id) }}" class="text-decoration-none">
                        {{ $registration->registration_number }}
                    </a>
                </h4>
                <div>
                    <a href="{{ route('registrations.edit', $registration->id) }}" class="btn btn-warning btn-sm bi-pencil-square">
                        Edit Registration</a>
                    <form action="{{ route('registrations.destroy', $registration->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm bi-trash-fill" onclick="return confirm('Are you sure?')">
                            Delete Registration</button>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="list-group col-md-6">
                    <div class="list-group-item"><strong>Registration:</strong> {{ $registration->registration_number }}</div>
                    <div class="list-group-item"><strong>Max Takeoff Weight:</strong> {{ $registration->aircraftType->max_takeoff_weight }} kg</div>
                    <div class="list-group-item"><strong>Basic Weight:</strong> {{ $registration->basic_weight }} kg</div>
                    <div class="list-group-item"><strong>Basic Index:</strong> {{ $registration->basic_index }}</div>
                </div>
            </div>
            <div>
                <a href="{{ route('registrations.envelopes.create', $registration->id) }}"
                    class="btn btn-primary btn-sm mt-4 bi-plus-lg"> Add Envelope</a>
            </div>
        </div>
    </div>
@endsection
