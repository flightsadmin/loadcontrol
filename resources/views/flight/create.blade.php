@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card mt-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Add New Flight</h4>
                    <a href="{{ route('flights.index') }}" class="btn btn-sm btn-warning">Back</a>
                </div>
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <form action="{{ route('flights.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="registration_id" class="form-label">Registration</label>
                                <span><a class="btn btn-link bi-pencil-square p-0" href="{{ route('aircraft_types.index') }}"></a></span>
                                <select id="registration_id" name="registration_id"
                                    class="form-select @error('registration_id') is-invalid @enderror">
                                    @foreach ($registrations as $registration)
                                        <option value="{{ $registration->id }}"
                                            {{ old('registration_id') == $registration->id ? 'selected' : '' }}>
                                            {{ $registration->registration_number }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('registration_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="flight_number" class="form-label">Flight Number</label>
                                <input type="text" id="flight_number" name="flight_number"
                                    class="form-control @error('flight_number') is-invalid @enderror" value="{{ old('flight_number') }}">
                                @error('flight_number')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="departure" class="form-label">Departure</label>
                                <input type="datetime-local" id="departure" name="departure"
                                    class="form-control @error('departure') is-invalid @enderror" value="{{ old('departure') }}">
                                @error('departure')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="arrival" class="form-label">Arrival</label>
                                <input type="datetime-local" id="arrival" name="arrival"
                                    class="form-control @error('arrival') is-invalid @enderror" value="{{ old('arrival') }}">
                                @error('arrival')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="origin" class="form-label">Origin</label>
                                <input type="text" id="origin" name="origin"
                                    class="form-control @error('origin') is-invalid @enderror" value="{{ old('origin') }}">
                                @error('origin')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="destination" class="form-label">Destination</label>
                                <input type="text" id="destination" name="destination"
                                    class="form-control @error('destination') is-invalid @enderror" value="{{ old('destination') }}">
                                @error('destination')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="airline_id" class="form-label">Airline</label>
                                <span><a class="btn btn-link bi-pencil-square p-0" href="{{ route('airlines.index') }}"></a></span>
                                <select id="airline_id" name="airline_id" class="form-select @error('airline_id') is-invalid @enderror">
                                    <option value="" selected disabled> Select Airline</option>
                                    @foreach ($airlines as $airline)
                                        <option value="{{ $airline->id }}" {{ old('airline_id') == $airline->id ? 'selected' : '' }}>
                                            {{ $airline->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('airline_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="flight_type" class="form-label">Flight Type</label>
                                <select id="flight_type" name="flight_type" class="form-select @error('flight_type') is-invalid @enderror">
                                    <option value="" selected disabled>Select Flight Type</option>
                                    <option value="International" {{ old('flight_type') == 'International' ? 'selected' : '' }}>International
                                    </option>
                                    <option value="Domestic" {{ old('flight_type') == 'Domestic' ? 'selected' : '' }}>Domestic</option>
                                </select>
                                @error('flight_type')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary bi-floppy-fill float-end"> Save Flight</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
