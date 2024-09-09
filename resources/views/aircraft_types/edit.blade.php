@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card mt-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Add Aircraft Type</h4>
                    <a href="{{ route('aircraft_types.index') }}"
                        class="btn btn-secondary btn-sm bi-backspace float-end mt-0"> Back</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('aircraft_types.update', $aircraftType->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <h6 class="fw-bold text-decoration-underline">AIRCRAFT DATA</h6>
                    @include('aircraft_types.form')
                </form>
            </div>
        </div>
    </div>
@endsection
