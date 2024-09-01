@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card mt-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Add New Aircraft Registration</h4>
                    <a href="{{ route('aircraft_types.show', $aircraftType->id) }}"
                        class="btn btn-secondary btn-sm bi-backspace float-end mt-0"> Back</a>
                </div>
            </div>
            <div class="card-body">
                <form class="row" action="{{ route('aircraft_types.registrations.store', $aircraftType->id) }}" method="POST">
                    @csrf
                    <div class="col-6 mb-3">
                        <label for="registration_number" class="form-label">Registration Code</label>
                        <input type="text" name="registration_number" id="registration_number"
                            class="form-control @error('registration_number') is-invalid @enderror"
                            value="{{ old('registration_number') }}">
                        @error('registration_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-6 mb-3">
                        <label for="basic_weight" class="form-label">Basic Weight</label>
                        <input type="number" name="basic_weight" id="basic_weight"
                            class="form-control @error('basic_weight') is-invalid @enderror"
                            value="{{ old('basic_weight') }}">
                        @error('basic_weight')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-6 mb-3">
                        <label for="basic_index" class="form-label">Basic Index</label>
                        <input type="number" name="basic_index" id="basic_index"
                            class="form-control @error('basic_index') is-invalid @enderror"
                            value="{{ old('basic_index') }}">
                        @error('basic_index')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <button type="submit" class="btn btn-sm btn-primary bi-floppy-fill float-end"> Add Registration</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
