@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card mt-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Add Aircraft</h4>
                    <a href="{{ route('registrations.index') }}"
                        class="btn btn-secondary btn-sm bi-backspace float-end mt-0"> Back</a>
                </div>
            </div>
            <div class="card-body">
                <form class="row" action="{{ route('registrations.store') }}" method="POST">
                    @csrf
                    <div class="col-md-6 mb-3">
                        <label for="registration" class="form-label">Name</label>
                        <input type="text" id="registration" name="registration" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="max_takeoff_weight" class="form-label">Max Takeoff Weight</label>
                        <input type="number" id="max_takeoff_weight" name="max_takeoff_weight" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="empty_weight" class="form-label">Empty Weight</label>
                        <input type="number" id="empty_weight" name="empty_weight" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="fuel_capacity" class="form-label">Fuel Capacity</label>
                        <input type="number" id="fuel_capacity" name="fuel_capacity" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="cg_range_min" class="form-label">CG Range Min</label>
                        <input type="number" id="cg_range_min" name="cg_range_min" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="cg_range_max" class="form-label">CG Range Max</label>
                        <input type="number" id="cg_range_max" name="cg_range_max" class="form-control" required>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary float-end">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
