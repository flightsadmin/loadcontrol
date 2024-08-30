@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card mt-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Add New Cargo</h4>
                    <a href="{{ route('flights.cargos.index', $flight->id) }}"
                        class="btn btn-secondary btn-sm bi-backspace float-end mt-0"> Back</a>
                </div>
            </div>
            <div class="card-body">
                <form class="row" action="{{ route('flights.cargos.store', $flight->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="flight_id" value="{{ $flight->id }}">
                    <div class="col-md-6 mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select id="type" name="type" class="form-select" required>
                            <option value=""> Select</option>
                            <option value="baggage"> Baggage</option>
                            <option value="cargo"> Cargo</option>
                            <option value="mail"> Mail</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="pieces" class="form-label">Pieces</label>
                        <input type="number" id="pieces" name="pieces" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="weight" class="form-label">Weight</label>
                        <input type="number" id="weight" name="weight" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="hold_id" class="form-label">Position (Hold)</label>
                        <select id="hold_id" name="hold_id" class="form-select">
                            <option value="">Select Hold</option>
                            @foreach ($flight->registration->holds as $hold)
                                <option value="{{ $hold->id }}">{{ $hold->hold_no }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-sm btn-primary bi-floppy float-end"> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
