@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Add New Cargo</h1>
    <form action="{{ route('flights.cargos.store', $flight->id) }}" method="POST">
        @csrf
        <input type="hidden" name="flight_id" value="{{ $flight->id }}">
        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select id="type" name="type" class="form-select" required>
                <option value=""> Select</option>
                <option value="baggage"> Baggage</option>
                <option value="cargo"> Cargo</option>
                <option value="mail"> Mail</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="pieces" class="form-label">Pieces</label>
            <input type="number" id="pieces" name="pieces" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="weight" class="form-label">Weight</label>
            <input type="number" id="weight" name="weight" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="hold_id" class="form-label">Position (Hold)</label>
            <select id="hold_id" name="hold_id" class="form-select">
                <option value="">Select Hold</option>
                @foreach ($flight->registration->holds as $hold)
                    <option value="{{ $hold->id }}">{{ $hold->hold_no }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection
