<div class="row mb-3">
    <div class="col-md-4">
        <label for="aircraft_type" class="form-label">Aircraft Type</label>
        <input type="text" name="aircraft_type" id="aircraft_type" class="form-control @error('aircraft_type') is-invalid @enderror"
            value="{{ old('aircraft_type', $aircraftType->aircraft_type ?? '') }}">
        @error('aircraft_type')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4">
        <label for="manufacturer" class="form-label">Manufacturer</label>
        <input type="text" name="manufacturer" id="manufacturer" class="form-control @error('manufacturer') is-invalid @enderror"
            value="{{ old('manufacturer', $aircraftType->manufacturer ?? '') }}">
        @error('manufacturer')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4">
        <label for="max_fuel_weight" class="form-label">Max Fuel Weight</label>
        <input type="number" name="max_fuel_weight" id="max_fuel_weight"
            class="form-control @error('max_fuel_weight') is-invalid @enderror"
            value="{{ old('max_fuel_weight', $aircraftType->max_fuel_weight ?? '') }}">
        @error('max_fuel_weight')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-4">
        <label for="max_zero_fuel_weight" class="form-label">Max Zero Fuel Weight</label>
        <input type="number" name="max_zero_fuel_weight" id="max_zero_fuel_weight"
            class="form-control @error('max_zero_fuel_weight') is-invalid @enderror"
            value="{{ old('max_zero_fuel_weight', $aircraftType->max_zero_fuel_weight ?? '') }}">
        @error('max_zero_fuel_weight')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4">
        <label for="max_takeoff_weight" class="form-label">Max Takeoff Weight</label>
        <input type="number" name="max_takeoff_weight" id="max_takeoff_weight"
            class="form-control @error('max_takeoff_weight') is-invalid @enderror"
            value="{{ old('max_takeoff_weight', $aircraftType->max_takeoff_weight ?? '') }}">
        @error('max_takeoff_weight')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4">
        <label for="max_landing_weight" class="form-label">Max Landing Weight</label>
        <input type="number" name="max_landing_weight" id="max_landing_weight"
            class="form-control @error('max_landing_weight') is-invalid @enderror"
            value="{{ old('max_landing_weight', $aircraftType->max_landing_weight ?? '') }}">
        @error('max_landing_weight')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <label for="deck_crew" class="form-label">Deck Crew</label>
        <input type="number" name="deck_crew" id="deck_crew" class="form-control @error('deck_crew') is-invalid @enderror"
            value="{{ old('deck_crew', $aircraftType->deck_crew ?? '') }}">
        @error('deck_crew')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4">
        <label for="cabin_crew" class="form-label">Cabin Crew</label>
        <input type="number" name="cabin_crew" id="cabin_crew" class="form-control @error('cabin_crew') is-invalid @enderror"
            value="{{ old('cabin_crew', $aircraftType->cabin_crew ?? '') }}">
        @error('cabin_crew')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-4">
        <label for="fwd_cg_limit" class="form-label">Fwd CG Limit</label>
        <input type="number" step="0.01" name="fwd_cg_limit" id="fwd_cg_limit"
            class="form-control @error('fwd_cg_limit') is-invalid @enderror"
            value="{{ old('fwd_cg_limit', $aircraftType->fwd_cg_limit ?? '') }}">
        @error('fwd_cg_limit')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4">
        <label for="aft_cg_limit" class="form-label">Aft CG Limit</label>
        <input type="number" step="0.01" name="aft_cg_limit" id="aft_cg_limit"
            class="form-control @error('aft_cg_limit') is-invalid @enderror"
            value="{{ old('aft_cg_limit', $aircraftType->aft_cg_limit ?? '') }}">
        @error('aft_cg_limit')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
