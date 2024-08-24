@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Edit Aircraft</h1>
    <form action="{{ route('registrations.update', $registration->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="registration" class="form-label">Name</label>
            <input type="text" id="registration" name="registration" class="form-control" value="{{ $registration->registration }}" required>
        </div>
        <div class="mb-3">
            <label for="max_takeoff_weight" class="form-label">Max Takeoff Weight</label>
            <input type="number" id="max_takeoff_weight" name="max_takeoff_weight" class="form-control" value="{{ $registration->max_takeoff_weight }}" required>
        </div>
        <div class="mb-3">
            <label for="empty_weight" class="form-label">Empty Weight</label>
            <input type="number" id="empty_weight" name="empty_weight" class="form-control" value="{{ $registration->empty_weight }}" required>
        </div>
        <div class="mb-3">
            <label for="fuel_capacity" class="form-label">Fuel Capacity</label>
            <input type="number" id="fuel_capacity" name="fuel_capacity" class="form-control" value="{{ $registration->fuel_capacity }}" required>
        </div>
        <div class="mb-3">
            <label for="cg_range_min" class="form-label">CG Range Min</label>
            <input type="number" id="cg_range_min" name="cg_range_min" class="form-control" value="{{ $registration->cg_range_min }}" required>
        </div>
        <div class="mb-3">
            <label for="cg_range_max" class="form-label">CG Range Max</label>
            <input type="number" id="cg_range_max" name="cg_range_max" class="form-control" value="{{ $registration->cg_range_max }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
