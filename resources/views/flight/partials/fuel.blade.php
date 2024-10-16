<div class="container-fluid">
    <div class="card mt-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5>Fuel Figure for: {{ $flight->flight_number }}</h5>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    @if ($flight->fuelFigure)
                        <div class="list-group">
                            <div class="list-group-item">
                                <strong>Block Fuel:</strong> {{ $flight->fuelFigure->block_fuel }}
                            </div>
                            <div class="list-group-item">
                                <strong>Taxi Fuel:</strong> {{ $flight->fuelFigure->taxi_fuel }}
                            </div>
                            <div class="list-group-item">
                                <strong>Trip Fuel:</strong> {{ $flight->fuelFigure->trip_fuel }}
                            </div>
                            <div class="list-group-item">
                                <strong>Crew:</strong> {{ $flight->fuelFigure->crew }}
                            </div>
                            <div class="list-group-item">
                                <strong>Pantry:</strong> {{ $flight->fuelFigure->pantry }}
                            </div>
                            <div class="list-group-item">
                                <a href="{{ route('flights.fuel-figures.create', $flight->id) }}"
                                    class="btn btn-sm btn-primary btn-sm bi-pencil-square float-end mt-0"> Edit Fuel Figure</a>
                            </div>
                        </div>
                    @else
                        <p>No fuel figure available for this flight.
                            <a class="bi-plus-circle-dotted" href="{{ route('flights.fuel-figures.create', $flight->id) }}"> Add Fuel</a>.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
