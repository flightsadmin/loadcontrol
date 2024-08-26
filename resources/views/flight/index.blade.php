@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        @isset($flight)
            <div class="mt-2">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="flight-tab" data-bs-toggle="tab" href="#flight" role="tab" aria-controls="flight"
                            data-tab="flight" aria-selected="true">Flight Data</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="passengers-tab" data-bs-toggle="tab" href="#passengers" role="tab" aria-controls="passengers"
                            data-tab="passengers" aria-selected="false">Passengers</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="cargo-tab" data-bs-toggle="tab" href="#cargo" role="tab" aria-controls="cargo"
                            data-tab="cargo" aria-selected="false">Deadload</a>
                    </li>
                </ul>

                <div class="tab-content mt-3" id="myTabContent">
                    <div class="tab-pane fade show active" id="flight" role="tabpanel" aria-labelledby="flight-tab">
                        @include('flight.partials.index', ['flight' => $flight])
                    </div>
                    <div class="tab-pane fade" id="passengers" role="tabpanel" aria-labelledby="passengers-tab">
                        @include('flight.partials.passengers', ['flight' => $flight])
                    </div>
                    <div class="tab-pane fade" id="cargo" role="tabpanel" aria-labelledby="cargo-tab">
                        @include('flight.partials.planning', ['flight' => $flight])
                    </div>
                </div>
            </div>
        @else
            <p class="mt-4">Select a flight from the sidebar to view details.</p>
        @endisset
    </div>
@endsection
