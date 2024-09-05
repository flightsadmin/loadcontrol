@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card mt-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4> {{ $airline->name }} </h4>
                    <a href="{{ route('airlines.index') }}"
                        class="btn btn-secondary btn-sm bi-backspace float-end mt-0"> Back</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="list-group col-md-6">
                        <div class="list-group-item"><strong>Airline:</strong> {{ $airline->name }}</div>
                        <div class="list-group-item"><strong>Iata Code:</strong> {{ $airline->iata_code }}</div>
                        <div class="list-group-item"><strong>Base:</strong> {{ $airline->base }}</div>
                        <div class="list-group-item"><strong>Base IATA Code:</strong> {{ $airline->base_iata_code }} kg</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
