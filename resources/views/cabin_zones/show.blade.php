@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Cabin Zone Details</div>

                <div class="card-body">
                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label text-md-end">Zone Name:</label>
                        <div class="col-md-6">
                            <p>{{ $cabinZone->zone_name }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label text-md-end">Max Capacity:</label>
                        <div class="col-md-6">
                            <p>{{ $cabinZone->max_capacity }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label text-md-end">Arm:</label>
                        <div class="col-md-6">
                            <p>{{ $cabinZone->arm }}</p>
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <a href="{{ route('cabin_zones.edit', $cabinZone->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('cabin_zones.destroy', $cabinZone->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                            <a href="{{ route('aircraft_types.cabin_zones.index', $cabinZone->aircraft_type_id) }}" class="btn btn-secondary">Back to List</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
