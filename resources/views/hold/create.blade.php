@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card mt-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Create Hold</h4>
                    <a href="{{ route('registrations.show', $registration->id) }}"
                        class="btn btn-secondary btn-sm bi-backspace float-end mt-0"> Back</a>
                </div>
            </div>
            <div class="card-body">
                <form class="row" action="{{ route('registrations.holds.store', $registration->id) }}" method="POST">
                    @csrf
                    <div class="col-md-6 mb-3">
                        <label for="hold_no" class="form-label">Hold No</label>
                        <input type="text" id="hold_no" name="hold_no" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="fwd" class="form-label">FWD Distance (m)</label>
                        <input type="number" id="fwd" name="fwd" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="aft" class="form-label">AFT Distance (m)</label>
                        <input type="number" id="aft" name="aft" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="max" class="form-label">AFT Distance (m)</label>
                        <input type="number" id="max" name="max" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="restrictions" class="form-label">Restrictions</label>
                        <input type="text" id="restrictions" name="restrictions" class="form-control">
                    </div>
                    <div>
                        <button type="submit" class="btn btn-sm btn-primary float-end">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
