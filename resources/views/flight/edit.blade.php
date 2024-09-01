@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card mt-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Edit Flight: {{ $flight->flight_number }}</h4>
                    <a href="{{ route('flights.show', $flight) }}"
                        class="btn btn-secondary btn-sm bi-backspace float-end mt-0"> Back</a>
                </div>
            </div>
            <div class="card-body">
                <form class="row" action="{{ route('flights.update', $flight->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="registration_id" class="form-label">Registration</label>
                            <span><a class="btn btn-link bi-pencil-square px-2"
                                    href="{{ route('registrations.edit', $flight->registration_id) }}"></a></span>
                            <span><a class="btn btn-link bi-eye-fill text-info px-2"
                                    href="{{ route('registrations.show', $flight->registration_id) }}"></a></span>
                            <select id="registration_id" name="registration_id"
                                class="form-select @error('registration_id') is-invalid @enderror">
                                <option value="" selected disabled>Select Registration</option>
                                @foreach ($registrations as $registration)
                                    <option value="{{ $registration->id }}"
                                        {{ $flight->registration_id == $registration->id ? 'selected' : '' }}> {{ $registration->registration_number }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="flight_number" class="form-label">Flight Number</label>
                            <input type="text" id="flight_number" name="flight_number"
                                class="form-control @error('flight_number') is-invalid @enderror"
                                value="{{ old('flight_number', $flight->flight_number) }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="departure" class="form-label">Departure</label>
                            <input type="datetime-local" id="departure" name="departure"
                                class="form-control @error('departure') is-invalid @enderror"
                                value="{{ old('departure', $flight->departure) }}">
                        </div>
                        <div class="col-md-6">
                            <label for="arrival" class="form-label">Arrival</label>
                            <input type="datetime-local" id="arrival" name="arrival"
                                class="form-control @error('arrival') is-invalid @enderror"
                                value="{{ old('arrival', $flight->arrival) }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="origin" class="form-label">Origin</label>
                            <input type="text" id="origin" name="origin"
                                class="form-control @error('origin') is-invalid @enderror"
                                value="{{ old('origin', $flight->origin) }}">
                        </div>
                        <div class="col-md-6">
                            <label for="destination" class="form-label">Destination</label>
                            <input type="text" id="destination" name="destination"
                                class="form-control @error('destination') is-invalid @enderror"
                                value="{{ old('destination', $flight->destination) }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="airline" class="form-label">Airline</label>
                            <select id="airline" name="airline" class="form-select @error('airline') is-invalid @enderror">
                                <option value="" selected disabled>Select Airline</option>
                                <option value="Qatar Airways" {{ $flight->airline == 'Qatar Airways' ? 'selected' : '' }}>
                                    Qatar Airways </option>
                                <option value="Kenya Airways" {{ $flight->airline == 'Kenya Airways' ? 'selected' : '' }}>
                                    Kenya Airways </option>
                            </select>
                            @error('airline')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="flight_type" class="form-label">Flight Type</label>
                            <select id="flight_type" name="flight_type" class="form-control @error('flight_type') is-invalid @enderror">
                                <option value="" selected disabled>Select Flight Type</option>
                                <option value="Domestic" {{ $flight->flight_type == 'Domestic' ? 'selected' : '' }}>Domestic</option>
                                <option value="International" {{ $flight->flight_type == 'International' ? 'selected' : '' }}>International
                                </option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-sm btn-primary bi-floppy-fill float-end"> Update Flight</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
