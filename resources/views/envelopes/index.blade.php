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
                @if ($envelopes->isEmpty())
                    <p>No envelopes found for this aircraft type.</p>
                @else
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Envelope Type</th>
                                <th>X</th>
                                <th>Y</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($envelopes as $envelope)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $envelope->envelope_type }}</td>
                                    <td>{{ $envelope->x }}</td>
                                    <td>{{ $envelope->y }}</td>
                                    <td>
                                        <a href="{{ route('envelopes.edit', $envelope->id) }}" class="btn btn-sm btn-warning bi-pencil-square"> Edit</a>
                                        <form action="{{ route('envelopes.destroy', $envelope->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger bi-trash-fill"
                                                onclick="return confirm('Are you sure?')"> Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
{{-- 

@extends('layouts.app')

@section('content')
<div class="container">
    @if ($envelopes->isEmpty())
        <p>No envelopes found for this aircraft type.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Envelope Type</th>
                    <th>X</th>
                    <th>Y</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($envelopes as $envelope)
                    <tr>
                        <td>{{ $envelope->envelope_type }}</td>
                        <td>{{ $envelope->x }}</td>
                        <td>{{ $envelope->y }}</td>
                        <td>
                            <a href="{{ route('envelopes.edit', $envelope->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('envelopes.destroy', $envelope->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection --}}
