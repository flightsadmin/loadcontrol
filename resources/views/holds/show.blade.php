@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card mt-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Hold Details - {{ $hold->hold_no }}</h4>
                    <a href="{{ route('aircraft_types.holds.index', $hold->aircraft_type_id) }}" class="btn btn-sm btn-warning">
                        Back to Holds
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5>Hold Number</h5>
                        <p>{{ $hold->hold_no }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>Forward Distance</h5>
                        <p>{{ $hold->fwd }}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5>Aft Distance</h5>
                        <p>{{ $hold->aft }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>Restrictions</h5>
                        <p>{{ $hold->restrictions }}</p>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('holds.edit', $hold->id) }}" class="btn btn-sm btn-primary bi-pencil-square"> Edit</a>
                    <form action="{{ route('holds.destroy', $hold->id) }}" method="POST" class="d-inline ms-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger bi-trash-fill"
                            onclick="return confirm('Are you sure you want to delete this hold?')">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
