@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Edit Flight</h1>
    <form action="{{ route('flights.update', $flight->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="registration_id" class="form-label">Registration</label>
            <select id="registration_id" name="registration_id" class="form-select" required>
                @foreach ($registrations as $registration)
                    <option value="{{ $registration->id }}" {{ $flight->registration_id == $registration->id ? 'selected' : '' }}>
                        {{ $registration->registration }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="flight_number" class="form-label">Flight Number</label>
            <input type="text" id="flight_number" name="flight_number" class="form-control" value="{{ $flight->flight_number }}" required>
        </div>
        <div class="mb-3">
            <label for="departure" class="form-label">Departure</label>
            <input type="text" id="departure" name="departure" class="form-control" value="{{ $flight->departure }}" required>
        </div>
        <div class="mb-3">
            <label for="arrival" class="form-label">Arrival</label>
            <input type="text" id="arrival" name="arrival" class="form-control" value="{{ $flight->arrival }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
