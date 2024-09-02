@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mt-4">
            <div class="card-header">
                <h4>Create New Hold for {{ $aircraftType->aircraft_type }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('aircraft_types.holds.store', $aircraftType->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="hold_no" class="form-label">Hold Number</label>
                        <input type="number" id="hold_no" name="hold_no" class="form-control" value="{{ old('hold_no') }}">
                    </div>
                    <div class="mb-3">
                        <label for="fwd" class="form-label">Forward Distance</label>
                        <input type="number" id="fwd" name="fwd" class="form-control" value="{{ old('fwd') }}">
                    </div>
                    <div class="mb-3">
                        <label for="aft" class="form-label">Aft Distance</label>
                        <input type="number" id="aft" name="aft" class="form-control" value="{{ old('aft') }}">
                    </div>
                    <div class="mb-3">
                        <label for="max" class="form-label">Maximum Weight</label>
                        <input type="number" id="max" name="max" class="form-control" value="{{ old('max') }}">
                    </div>
                    <div class="mb-3">
                        <label for="index" class="form-label">Index per KG</label>
                        <input type="number" id="index" name="index" class="form-control" step="any"
                            value="{{ old('index') }}">
                    </div>
                    <div class="mb-3">
                        <label for="restrictions" class="form-label">Restrictions</label>
                        <textarea id="restrictions" name="restrictions" class="form-control">{{ old('restrictions') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('aircraft_types.holds.index', $aircraftType->id) }}" class="btn btn-secondary">Back</a>
                </form>
            </div>
        </div>
    </div>
@endsection
