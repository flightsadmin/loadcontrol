@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Load Sheet for Flight {{ $flight->flight_number }}</h1>

    <form action="{{ route('flights.loadsheets.store', $flight->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="details" class="form-label">Details</label>
            <textarea id="details" name="details" class="form-control">{{ old('details') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save Load Sheet</button>
    </form>
</div>
@endsection
