@extends('layouts.app')

@section('content')
    <h1>Create Setting for {{ $aircraftType->aircraft_type }}</h1>

    <form action="{{ route('aircraft_types.settings.store', $aircraftType) }}" method="POST">
        @csrf

        <div class="form-group g-2">
            <label for="setting1">Setting 1:</label>
            <div class="form-check form-check-inline ms-4">
                <input class="form-check-input" type="radio" name="settings[setting1]" value="option1">
                <label class="form-check-label" for="inlineRadio1">Option 1</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="settings[setting1]" value="option2">
                <label class="form-check-label" for="inlineRadio2">Option 2</label>
            </div>
        </div>
        
        <button type="submit" class="btn btn-success">Save</button>
    </form>
@endsection
