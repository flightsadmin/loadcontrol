@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card my-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Envelopes for: {{ $aircraftType->aircraft_type }}</h4>
                    <a href="{{ route('aircraft_types.envelopes.create', $aircraftType->id) }}"
                        class="btn btn-sm btn-primary bi-plus-lg"> Add New Envelope</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>X</th>
                            <th>Y</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($envelopes as $envelope)
                            <tr>
                                <td>{{ $envelope->id }}</td>
                                <td>{{ $envelope->x }}</td>
                                <td>{{ $envelope->y }}</td>
                                <td>
                                    <a href="{{ route('envelopes.edit', $envelope->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('envelopes.destroy', $envelope->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">No envelopes found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
