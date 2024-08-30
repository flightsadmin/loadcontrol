@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card mt-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Edit Hold</h4>
                    <a href="{{ route('registrations.show', $hold->registration->id) }}"
                        class="btn btn-secondary btn-sm bi-backspace float-end mt-0"> Back</a>
                </div>
            </div>
            <div class="card-body">
                <form class="row" action="{{ isset($hold) ? route('holds.update', $hold->id) : route('holds.store', $registration->id) }}" method="POST">
                    @csrf
                    @if (isset($hold))
                        @method('PUT')
                    @endif
                    <div class="col-md-6 mb-3">
                        <label for="hold_no" class="form-label">Hold No</label>
                        <input type="text" id="hold_no" name="hold_no" class="form-control" value="{{ $hold->hold_no ?? old('hold_no') }}"
                            required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="fwd" class="form-label">FWD Distance (m)</label>
                        <input type="number" id="fwd" name="fwd" class="form-control" value="{{ $hold->fwd ?? old('fwd') }}"
                            required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="aft" class="form-label">AFT Distance (m)</label>
                        <input type="number" id="aft" name="aft" class="form-control" value="{{ $hold->aft ?? old('aft') }}"
                            required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="restrictions" class="form-label">Restrictions</label>
                        <input type="text" id="restrictions" name="restrictions" class="form-control"
                            value="{{ $hold->restrictions ?? old('restrictions') }}">
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary bi-floppy-fill float-end"> Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
