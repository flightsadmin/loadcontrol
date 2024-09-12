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
                                <option value="" selected disabled>Select Crew</option>
                                <option value="2/4" {{ old('crew', $fuelFigure->crew ?? '') == '2/4' ? 'selected' : '' }}>2/4</option>
                                <option value="2/5" {{ old('crew', $fuelFigure->crew ?? '') == '2/5' ? 'selected' : '' }}>2/5</option>
                                <option value="2/6" {{ old('crew', $fuelFigure->crew ?? '') == '2/6' ? 'selected' : '' }}>2/6</option>
                                <option value="2/7" {{ old('crew', $fuelFigure->crew ?? '') == '2/7' ? 'selected' : '' }}>2/7</option>
                                <option value="3/4" {{ old('crew', $fuelFigure->crew ?? '') == '3/4' ? 'selected' : '' }}>3/4</option>
                                <option value="3/5" {{ old('crew', $fuelFigure->crew ?? '') == '3/5' ? 'selected' : '' }}>3/5</option>
                                <option value="3/6" {{ old('crew', $fuelFigure->crew ?? '') == '3/6' ? 'selected' : '' }}>3/6</option>
                                <option value="4/4" {{ old('crew', $fuelFigure->crew ?? '') == '4/4' ? 'selected' : '' }}>4/4</option>
                                <option value="4/5" {{ old('crew', $fuelFigure->crew ?? '') == '4/5' ? 'selected' : '' }}>4/5</option>
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
                                <option value="" selected disabled>Select Pantry</option>
                                @foreach ($flight->registration->aircraftType->settings['pantries'] ?? [] as $pantry)
                                    @dump($pantry)
                                    <option value="{{ $pantry['name'] }}"
                                        {{ $flight->fuelFigure->pantry ?? '' == $pantry['name'] ? 'selected' : '' }}>
                                        {{ $pantry['name'] }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pantry')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary bi-floppy-fill float-end">
                        {{ isset($fuelFigure) ? 'Update' : 'Save' }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
