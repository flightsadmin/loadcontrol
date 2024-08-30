@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card mt-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Edit Cargo</h4>
                    <a href="{{ route('flights.cargos.index', $flight->id) }}"
                        class="btn btn-secondary btn-sm bi-backspace float-end mt-0"> Back</a>
                </div>
            </div>
            <div class="card-body">
                    <form class="row" action="{{ route('cargos.update', $cargo->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="flight_id" value="{{ $flight->id }}">
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label">Type</label>
                            <select id="type" name="type" class="form-select" required>
                                <option value=""> Select</option>
                                <option value="baggage" {{ $cargo->type == 'baggage' ? 'selected' : '' }}> Baggage</option>
                                <option value="cargo" {{ $cargo->type == 'cargo' ? 'selected' : '' }}> Cargo</option>
                                <option value="mail" {{ $cargo->type == 'mail' ? 'selected' : '' }}> Mail</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="pieces" class="form-label">Pieces</label>
                            <input type="number" id="pieces" name="pieces" class="form-control" value="{{ $cargo->pieces }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="weight" class="form-label">Weight</label>
                            <input type="number" id="weight" name="weight" class="form-control" value="{{ $cargo->weight }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="hold_id" class="form-label">Position (Hold)</label>
                            <select id="hold_id" name="hold_id" class="form-select">
                                <option value="">Select Hold</option>
                                @foreach ($holds as $hold)
                                    <option value="{{ $hold->id }}" {{ $cargo->hold_id == $hold->id ? 'selected' : '' }}>
                                        {{ $hold->hold_no }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-sm btn-primary bi-floppy-fill float-end"> Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
