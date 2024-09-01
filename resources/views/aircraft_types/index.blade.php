@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card mt-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Aircraft Types</h4>
                    <a href="{{ route('aircraft_types.create') }}"
                        class="btn btn-info btn-sm bi-plus-lg float-end mt-0"> Add New Aircraft Type</a>
                </div>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach ($aircraftTypes as $aircraftType)
                        <li class="list-group-item">
                            <a href="{{ route('aircraft_types.show', $aircraftType->id) }}">
                                {{ $aircraftType->aircraft_type }}
                            </a>
                            <form action="{{ route('aircraft_types.destroy', $aircraftType->id) }}" method="POST" class="float-end ms-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                            <a href="{{ route('aircraft_types.edit', $aircraftType->id) }}" class="btn btn-secondary btn-sm float-end">Edit</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
