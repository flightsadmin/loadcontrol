<div class="container-fluid">
    <div class="card mt-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5>Flight Number: {{ $flight->flight_number }}</h5>
                <a href="{{ route('flights.edit', $flight->id) }}" class="btn btn-sm btn-warning bi-pencil-square"> Edit Flight</a>
            </div>
        </div>
        <div class="card-body">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <p class="card-text"><strong>Departure:</strong> {{ $flight->departure }}</p>
                        <p class="card-text"><strong>Arrival:</strong> {{ $flight->arrival }}</p>
                        <p class="card-text"><strong>Origin:</strong> {{ $flight->route->origin }}</p>
                        <p class="card-text"><strong>Destination:</strong> {{ $flight->route->destination }}</p>
                        <p class="card-text"><strong>Airline:</strong> {{ $flight->airline->name }}</p>
                        <p class="card-text"><strong>Registration:</strong> {{ $flight->registration->registration_number }}
                            <a href="{{ route('registrations.edit', $flight->registration->id) }}"
                                class="btn btn-link p-0 ms-2 bi-pencil-square text-danger"></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
