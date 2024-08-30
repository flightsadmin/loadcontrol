@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card mt-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Edit Aircraft</h4>
                    <a href="{{ route('registrations.index') }}"
                        class="btn btn-secondary btn-sm bi-backspace float-end mt-0"> Back</a>
                </div>
            </div>
            <div class="card-body">
                <form class="row" action="{{ route('registrations.update', $registration->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="col-md-4 mb-3">
                        <label for="registration" class="form-label">Registration</label>
                        <input type="text" id="registration" name="registration" class="form-control"
                            value="{{ $registration->registration }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="basic_weight" class="form-label">Basic Weight</label>
                        <input type="number" id="basic_weight" name="basic_weight" class="form-control"
                            value="{{ $registration->basic_weight }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="basic_index" class="form-label">Basic Index</label>
                        <input type="number" id="basic_index" name="basic_index" class="form-control"
                            value="{{ $registration->basic_index }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="max_zero_fuel_weight" class="form-label">Max Zero Fuel Weight</label>
                        <input type="number" id="max_zero_fuel_weight" name="max_zero_fuel_weight" class="form-control"
                            value="{{ $registration->max_zero_fuel_weight }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="max_takeoff_weight" class="form-label">Max Takeoff Weight</label>
                        <input type="number" id="max_takeoff_weight" name="max_takeoff_weight" class="form-control"
                            value="{{ $registration->max_takeoff_weight }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="max_landing_weight" class="form-label">Max Landing Weight</label>
                        <input type="number" id="max_landing_weight" name="max_landing_weight" class="form-control"
                            value="{{ $registration->max_landing_weight }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="fuel_capacity" class="form-label">Fuel Capacity</label>
                        <input type="number" id="fuel_capacity" name="fuel_capacity" class="form-control"
                            value="{{ $registration->fuel_capacity }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="deck_crew" class="form-label">Deck Crew</label>
                        <input type="number" id="deck_crew" name="deck_crew" class="form-control"
                            value="{{ $registration->deck_crew }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="cabin_crew" class="form-label">Cabin Crew</label>
                        <input type="number" id="cabin_crew" name="cabin_crew" class="form-control"
                            value="{{ $registration->cabin_crew }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="passenger_zones" class="form-label">Passenger Zones</label>
                        <input type="number" id="passenger_zones" name="passenger_zones" class="form-control"
                            value="{{ $registration->passenger_zones }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="fwd_cg_limit" class="form-label">CG Range Min</label>
                        <input type="number" id="fwd_cg_limit" name="fwd_cg_limit" class="form-control"
                            value="{{ $registration->fwd_cg_limit }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="aft_cg_limit" class="form-label">CG Range Max</label>
                        <input type="number" id="aft_cg_limit" name="aft_cg_limit" class="form-control"
                            value="{{ $registration->aft_cg_limit }}">
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary bi-floppy float-end"> Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
