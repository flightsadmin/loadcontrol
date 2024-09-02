@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card mt-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Create Envelope for: {{ $aircraftType->aircraft_type }}</h4>
                    <a href="{{ route('aircraft_types.envelopes.index', $aircraftType->id) }}"
                        class="btn btn-secondary btn-sm bi-backspace float-end mt-0"> Back</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('aircraft_types.envelopes.store', $aircraftType->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="envelope_type" class="form-label">Envelope Type</label>
                        <input type="text" name="envelope_type" id="envelope_type" class="form-control" value="{{ old('envelope_type') }}" required>
                    </div>
            
                    <div class="mb-3">
                        <label for="x" class="form-label">X</label>
                        <input type="number" step="0.01" name="x" id="x" class="form-control" value="{{ old('x') }}" required>
                    </div>
            
                    <div class="mb-3">
                        <label for="y" class="form-label">Y</label>
                        <input type="number" step="0.01" name="y" id="y" class="form-control" value="{{ old('y') }}" required>
                    </div>
            
                    <button type="submit" class="btn btn-success">Create Envelope</button>
                    <a href="{{ route('aircraft_types.show', $aircraftType->id) }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
