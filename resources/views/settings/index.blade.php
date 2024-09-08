@extends('layouts.app')

@section('content')
    <h1>Settings for {{ $aircraftType->aircraft_type }}</h1>

    <a href="{{ route('aircraft_types.settings.create', $aircraftType) }}" class="btn btn-primary">Add New Setting</a>

    @if($setting)
        <ul class="list-group">
                <li class="list-group-item">
                    <strong>Setting 1:</strong> {{ $setting->settings['settings']['setting1'] }} <br>
                    <strong>Setting 2:</strong> {{ $setting->settings['settings']['setting2'] }} <br>
                    <strong>Setting 3:</strong> {{ $setting->settings['settings']['setting3'] }} <br>

                    <a href="{{ route('settings.edit', $setting) }}" class="btn btn-sm btn-secondary">Edit</a>
                    <form action="{{ route('settings.destroy', $setting) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </li>
        </ul>
    @endif
@endsection
