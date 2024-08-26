@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Add New Flight</h1>
    <form action="{{ route('flights.store') }}" method="POST">
        @csrf

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="registration_id" class="form-label">Registration</label>
                <select id="registration_id" name="registration_id" class="form-select @error('registration_id') is-invalid @enderror" required>
                    @foreach ($registrations as $registration)
                        <option value="{{ $registration->id }}" {{ old('registration_id') == $registration->id ? 'selected' : '' }}>
                            {{ $registration->registration }}
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
                <input type="text" id="flight_number" name="flight_number" class="form-control @error('flight_number') is-invalid @enderror" value="{{ old('flight_number') }}" required>
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
                <input type="datetime-local" id="departure" name="departure" class="form-control @error('departure') is-invalid @enderror" value="{{ old('departure') }}" required>
                @error('departure')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="arrival" class="form-label">Arrival</label>
                <input type="datetime-local" id="arrival" name="arrival" class="form-control @error('arrival') is-invalid @enderror" value="{{ old('arrival') }}" required>
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
                <input type="text" id="origin" name="origin" class="form-control @error('origin') is-invalid @enderror" value="{{ old('origin') }}" required>
                @error('origin')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="destination" class="form-label">Destination</label>
                <input type="text" id="destination" name="destination" class="form-control @error('destination') is-invalid @enderror" value="{{ old('destination') }}" required>
                @error('destination')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="airline" class="form-label">Airline</label>
                <input type="text" id="airline" name="airline" class="form-control @error('airline') is-invalid @enderror" value="{{ old('airline') }}" required>
                @error('airline')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="flight_type" class="form-label">Flight Type</label>
                <select id="flight_type" name="flight_type" class="form-select @error('flight_type') is-invalid @enderror" required>
                    <option value="Domestic" {{ old('flight_type') == 'Domestic' ? 'selected' : '' }}>Domestic</option>
                    <option value="International" {{ old('flight_type') == 'International' ? 'selected' : '' }}>International</option>
                </select>
                @error('flight_type')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Save Flight</button>
    </form>
@endsection
