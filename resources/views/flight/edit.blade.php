@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card mt-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Edit Flight: {{ $flight->flight_number }}</h4>
                    <a href="{{ route('flights.cargos.create', $flight->id) }}"
                        class="btn btn-primary btn-sm bi-plus-circle-dotted float-end mt-0"> Add Deadload</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <form action="{{ route('flights.update', $flight->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="registration_id" class="form-label">Registration</label>
                                <select id="registration_id" name="registration_id" class="form-select" required>
                                    @foreach ($registrations as $registration)
                                        <option value="{{ $registration->id }}"
                                            {{ $flight->registration_id == $registration->id ? 'selected' : '' }}>
                                            {{ $registration->registration }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="flight_number" class="form-label">Flight Number</label>
                                <input type="text" id="flight_number" name="flight_number" class="form-control"
                                    value="{{ old('flight_number', $flight->flight_number) }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="departure" class="form-label">Departure</label>
                                <input type="datetime-local" id="departure" name="departure" class="form-control"
                                    value="{{ old('departure', $flight->departure) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="arrival" class="form-label">Arrival</label>
                                <input type="datetime-local" id="arrival" name="arrival" class="form-control"
                                    value="{{ old('arrival', $flight->arrival) }}"
                                    required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="origin" class="form-label">Origin</label>
                                <input type="text" id="origin" name="origin" class="form-control"
                                    value="{{ old('origin', $flight->origin) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="destination" class="form-label">Destination</label>
                                <input type="text" id="destination" name="destination" class="form-control"
                                    value="{{ old('destination', $flight->destination) }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="airline" class="form-label">Airline</label>
                                <input type="text" id="airline" name="airline" class="form-control"
                                    value="{{ old('airline', $flight->airline) }}"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label for="flight_type" class="form-label">Flight Type</label>
                                <select id="flight_type" name="flight_type" class="form-select" required>
                                    <option value="Domestic" {{ $flight->flight_type == 'Domestic' ? 'selected' : '' }}>Domestic</option>
                                    <option value="International" {{ $flight->flight_type == 'International' ? 'selected' : '' }}>International
                                    </option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Flight</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
