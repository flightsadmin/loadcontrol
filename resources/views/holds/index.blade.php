@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card mt-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>
                        <a href="{{ route('aircraft_types.index') }}" class="text-reset btn btn-lg btn-link">
                            Holds for {{ $aircraftType->aircraft_type }}
                        </a>
                    </h4>
                    <a href="{{ route('aircraft_types.holds.create', $aircraftType->id) }}" class="btn btn-primary btn-sm">Add New Hold</a>
                </div>
            </div>
            <div class="card-body">
                @if ($holds->isEmpty())
                    <p>No holds found for this aircraft type.</p>
                @else
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Hold Number</th>
                                <th>Forward Distance</th>
                                <th>Aft Distance</th>
                                <th>Maximun</th>
                                <th>Index Per Kg</th>
                                <th>Restrictions</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($holds as $hold)
                                <tr>
                                    <td>{{ $hold->hold_no }}</td>
                                    <td>{{ $hold->fwd }}</td>
                                    <td>{{ $hold->aft }}</td>
                                    <td>{{ $hold->max }}</td>
                                    <td>{{ $hold->index }}</td>
                                    <td>{{ $hold->restrictions }}</td>
                                    <td>
                                        <a href="{{ route('holds.show', $hold->id) }}" class="btn btn-info btn-sm bi-eye"></a>
                                        <a href="{{ route('holds.edit', $hold->id) }}" class="btn btn-primary btn-sm bi-pencil-square"></a>
                                        <form action="{{ route('holds.destroy', $hold->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm bi-trash-fill"
                                                onclick="return confirm('Are you sure you want to delete this hold?')"></button>
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
