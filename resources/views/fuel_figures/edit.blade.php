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
                            <input type="number" class="form-control" id="block_fuel" name="block_fuel"
                                value="{{ old('block_fuel', $fuelFigure->block_fuel ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="taxi_fuel" class="form-label">Taxi Fuel</label>
                            <input type="number" class="form-control" id="taxi_fuel" name="taxi_fuel"
                                value="{{ old('taxi_fuel', $fuelFigure->taxi_fuel ?? '') }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="trip_fuel" class="form-label">Trip Fuel</label>
                            <input type="number" class="form-control" id="trip_fuel" name="trip_fuel"
                                value="{{ old('trip_fuel', $fuelFigure->trip_fuel ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="crew" class="form-label">Crew</label>
                            <select id="crew" name="crew" class="form-select">
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
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="pantry" class="form-label">Crew</label>
                            <select id="pantry" name="pantry" class="form-select">
                                <option value="" selected>Select Pantry</option>
                                <option value="A" {{ old('pantry', $fuelFigure->pantry ?? '') == 'A' ? 'selected' : '' }}>Pantry A
                                </option>
                                <option value="B" {{ old('pantry', $fuelFigure->pantry ?? '') == 'B' ? 'selected' : '' }}>Pantry B
                                </option>
                                <option value="C" {{ old('pantry', $fuelFigure->pantry ?? '') == 'C' ? 'selected' : '' }}>Pantry C
                                </option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary bi-floppy-fill float-end"> {{ isset($fuelFigure) ? 'Update' : 'Save' }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
