@extends('layouts.app')

@section('content')
    <h1>Create Hold</h1>
    <form action="{{ route('registrations.holds.store', $registration->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="hold_no" class="form-label">Hold No</label>
            <input type="text" id="hold_no" name="hold_no" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="fwd" class="form-label">FWD Distance (m)</label>
            <input type="number" id="fwd" name="fwd" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="aft" class="form-label">AFT Distance (m)</label>
            <input type="number" id="aft" name="aft" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="restrictions" class="form-label">Restrictions</label>
            <input type="text" id="restrictions" name="restrictions" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
@endsection
