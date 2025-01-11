@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card mt-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5>{{ isset($fuelFigure) ? 'Edit' : 'Create' }} Fuel Figure</h5>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('flights.fuel-figures.store', $flight->id) }}">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="block_fuel" class="form-label">Block Fuel</label>
                            <input type="number" class="form-control @error('block_fuel') is-invalid @enderror" id="block_fuel"
                                name="block_fuel"
                                value="{{ old('block_fuel', $fuelFigure->block_fuel ?? '') }}">
                            @error('block_fuel')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="taxi_fuel" class="form-label">Taxi Fuel</label>
                            <input type="number" class="form-control @error('taxi_fuel') is-invalid @enderror" id="taxi_fuel" name="taxi_fuel"
                                value="{{ old('taxi_fuel', $fuelFigure->taxi_fuel ?? '') }}">
                            @error('taxi_fuel')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="trip_fuel" class="form-label">Trip Fuel</label>
                            <input type="number" class="form-control @error('trip_fuel') is-invalid @enderror" id="trip_fuel" name="trip_fuel"
                                value="{{ old('trip_fuel', $fuelFigure->trip_fuel ?? '') }}">
                            @error('trip_fuel')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="crew" class="form-label">Crew</label>
                            <select id="crew" name="crew" class="form-select @error('crew') is-invalid @enderror">
                                <option value="" disabled>Select Crew</option>
                                @foreach ($crewOptions as $option)
                                    <option value="{{ $option }}" {{ old('crew', $fuelFigure->crew ?? '') == $option ? 'selected' : '' }}>
                                        {{ $option }}</option>
                                @endforeach
                            </select>
                            @error('crew')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="pantry" class="form-label">Pantry</label>
                            <select id="pantry" name="pantry" class="form-select @error('pantry') is-invalid @enderror">
                                <option value="" disabled>Select Pantry</option>
                                @foreach ($flight->registration->aircraftType->settings['pantries'] ?? [] as $pantry)
                                    <option value="{{ $pantry['name'] }}"
                                        {{ old('pantry', $fuelFigure->pantry ?? '') == $pantry['name'] ? 'selected' : '' }}>
                                        {{ $pantry['name'] }}</option>
                                @endforeach
                            </select>
                            @error('pantry')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-sm btn-primary bi-floppy-fill float-end">
                        {{ isset($fuelFigure) ? 'Update Fuel Figure' : 'Save Fuel Figure' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
