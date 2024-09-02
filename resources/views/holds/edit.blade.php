@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mt-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Edit Hold for {{ $aircraftType->aircraft_type }}</h4>
                    <a href="{{ route('aircraft_types.holds.index', $aircraftType->id) }}"
                        class="btn btn-secondary btn-sm bi-backspace float-end mt-0"> Back</a>
                </div>
            </div>
            <div class="card-body">
                <form class="row" action="{{ route('holds.update', $hold->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="col-md-6 mb-3">
                        <label for="hold_no" class="form-label">Hold Number</label>
                        <input type="text" id="hold_no" name="hold_no" class="form-control" value="{{ old('hold_no', $hold->hold_no) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="fwd" class="form-label">Forward Distance</label>
                        <input type="number" id="fwd" name="fwd" class="form-control" value="{{ old('fwd', $hold->fwd) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="aft" class="form-label">Aft Distance</label>
                        <input type="number" id="aft" name="aft" class="form-control" value="{{ old('aft', $hold->aft) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="max" class="form-label">Maximum Weight</label>
                        <input type="number" id="max" name="max" class="form-control" value="{{ old('max', $hold->max) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="index" class="form-label">Index per KG</label>
                        <input type="number" id="index" name="index" class="form-control" step="any"
                            value="{{ old('index', $hold->index) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="restrictions" class="form-label">Restrictions</label>
                        <textarea id="restrictions" name="restrictions" class="form-control">{{ old('restrictions', $hold->restrictions) }}</textarea>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-sm btn-primary bi-floppy float-end"> Update Hold</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
