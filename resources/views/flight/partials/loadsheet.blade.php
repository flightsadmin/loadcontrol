@if ($flight->loadsheet)
    <div class="mb-3">
        <p><strong>Total Cargo Weight:</strong> {{ $flight->loadsheet->total_deadload_weight }} kgs</p>
        <p><strong>Total Passenger Weight:</strong> {{ $flight->loadsheet->total_passengers_weight }} kgs</p>
        <p><strong>Takeoff Fuel Weight:</strong> {{ $flight->loadsheet->total_fuel_weight }} liters</p>
        <p><strong>Gross Weight:</strong> {{ $flight->loadsheet->gross_weight }} kgs</p>
        <p><strong>Crew:</strong> {{ $flight->fuelFigure->crew ?? 'NIL' }}</p>
        <p><strong>Balance:</strong> {{ $flight->loadsheet->balance }}</p>
    </div>
@else
    <div class="mb-3">
        <p>No Load Sheet Created</p>
    </div>
@endif
