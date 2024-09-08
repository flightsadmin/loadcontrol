@extends('layouts.app')

@section('content')
    <h1>Edit Setting for {{ $aircraftType->aircraft_type }}</h1>

    <form action="{{ route('settings.update', $setting) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="setting1">Setting 1:</label><br>
            <input type="radio" name="settings[setting1]" value="option1" 
                   {{ $setting->settings['setting1'] == 'option1' ? 'checked' : '' }} required> Option 1<br>
            <input type="radio" name="settings[setting1]" value="option2" 
                   {{ $setting->settings['setting1'] == 'option2' ? 'checked' : '' }} required> Option 2<br>
        </div>

        <div class="form-group">
            <label for="setting2">Setting 2:</label><br>
            <input type="radio" name="settings[setting2]" value="true" 
                   {{ $setting->settings['setting2'] == 'true' ? 'checked' : '' }} required> True<br>
            <input type="radio" name="settings[setting2]" value="false" 
                   {{ $setting->settings['setting2'] == 'false' ? 'checked' : '' }} required> False<br>
        </div>

        <div class="form-group">
            <label for="setting3">Setting 3:</label><br>
            <input type="radio" name="settings[setting3]" value="high" 
                   {{ $setting->settings['setting3'] == 'high' ? 'checked' : '' }} required> High<br>
            <input type="radio" name="settings[setting3]" value="medium" 
                   {{ $setting->settings['setting3'] == 'medium' ? 'checked' : '' }} required> Medium<br>
            <input type="radio" name="settings[setting3]" value="low" 
                   {{ $setting->settings['setting3'] == 'low' ? 'checked' : '' }} required> Low<br>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
    </form>
@endsection
