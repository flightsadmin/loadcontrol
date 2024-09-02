@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card mt-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Edit Cabin Zone</h4>
                    {{-- <a href="{{ route('aircraft_types.show', $aircraftType->id) }}"
                        class="btn btn-secondary btn-sm bi-backspace float-end mt-0"> Back</a> --}}
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('cabin_zones.update', $cabinZone->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <label for="zone_name" class="col-md-4 col-form-label text-md-end">Zone Name</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="zone_name" name="zone_name"
                                value="{{ $cabinZone->zone_name }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="fwd" class="col-md-4 col-form-label text-md-end">FWD</label>
                        <div class="col-md-6">
                            <input type="number" step="any" class="form-control" id="fwd" name="fwd"
                                value="{{ $cabinZone->fwd }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="aft" class="col-md-4 col-form-label text-md-end">AFT</label>
                        <div class="col-md-6">
                            <input type="number" step="any" class="form-control" id="aft" name="aft"
                                value="{{ $cabinZone->aft }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="max_capacity" class="col-md-4 col-form-label text-md-end">Max Capacity</label>
                        <div class="col-md-6">
                            <input type="number" step="any" class="form-control" id="max_capacity" name="max_capacity"
                                value="{{ $cabinZone->max_capacity }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="index" class="col-md-4 col-form-label text-md-end">Index Per PAX</label>
                        <div class="col-md-6">
                            <input type="number" step="any" class="form-control" id="index" name="index"
                                value="{{ $cabinZone->index }}">
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
