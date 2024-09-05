@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card mt-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Update details for: {{ $airline->name }}</h4>
                    <a href="{{ route('airlines.index') }}"
                        class="btn btn-secondary btn-sm bi-backspace float-end mt-0"> Back</a>
                </div>
            </div>
            <div class="card-body">

                <form action="{{ route('airlines.update', $airline) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <h4>Airline Details</h4>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Airline Name</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name', $airline->name) }}"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="iata_code">IATA Code</label>
                                <input type="text" name="iata_code" id="iata_code" class="form-control"
                                    value="{{ old('iata_code', $airline->iata_code) }}" required maxlength="3">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="base">Base</label>
                                <input type="text" name="base" id="base" class="form-control"
                                    value="{{ old('base', $airline->base) }}"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="base_iata_code">Base IATA Code</label>
                                <input type="text" name="base_iata_code" id="base_iata_code" class="form-control"
                                    value="{{ old('base_iata_code', $airline->base_iata_code) }}" required maxlength="3">
                            </div>
                        </div>
                    </div>

                    <h4>Standard Weight</h4>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="deck_crew_weight">Deck Crew Weight</label>
                                <input type="number" name="settings[crew][deck_crew_weight]" id="deck_crew_weight" class="form-control"
                                    value="{{ old('settings[crew][deck_crew_weight]', $airline->settings['crew']['deck_crew_weight'] ?? 85) }}"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cabin_crew_weight">Cabin Crew Weight</label>
                                <input type="number" name="settings[crew][cabin_crew_weight]" id="cabin_crew_weight" class="form-control"
                                    value="{{ old('settings[crew][cabin_crew_weight]', $airline->settings['crew']['cabin_crew_weight'] ?? 70) }}"
                                    required>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="passenger_weight_male">Male Passenger Weight</label>
                                <input type="number" name="settings[passenger_weights][male]" id="passenger_weight_male" class="form-control"
                                    value="{{ old('settings[passenger_weights][male]', $airline->settings['passenger_weights']['male'] ?? 88) }}"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="passenger_weight_female">Female Passenger Weight</label>
                                <input type="number" name="settings[passenger_weights][female]" id="passenger_weight_female"
                                    class="form-control"
                                    value="{{ old('settings[passenger_weights][female]', $airline->settings['passenger_weights']['female'] ?? 70) }}"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="passenger_weight_child">Child Passenger Weight</label>
                                <input type="number" name="settings[passenger_weights][child]" id="passenger_weight_child" class="form-control"
                                    value="{{ old('settings[passenger_weights][child]', $airline->settings['passenger_weights']['child'] ?? 35) }}"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="passenger_weight_infant">Infant Passenger Weight</label>
                                <input type="number" name="settings[passenger_weights][infant]" id="passenger_weight_infant"
                                    class="form-control"
                                    value="{{ old('settings[passenger_weights][infant]', $airline->settings['passenger_weights']['infant'] ?? 0) }}"
                                    required>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pantry_setting">Pantry Setting</label>
                                <select name="settings[pantry]" id="pantry_setting" class="form-control" required>
                                    <option value="A"
                                        {{ old('settings[pantry]', $airline->settings['pantry'] ?? 'A') === 'A' ? 'selected' : '' }}>A</option>
                                    <option value="B"
                                        {{ old('settings[pantry]', $airline->settings['pantry'] ?? 'A') === 'B' ? 'selected' : '' }}>B</option>
                                    <!-- Add more options if needed -->
                                </select>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Airline</button>
                </form>
            </div>
        </div>
    </div>
@endsection