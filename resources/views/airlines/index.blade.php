@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card mt-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Airlines</h4>
                    <a href="{{ route('airlines.create') }}"
                        class="btn btn-primary btn-sm bi-plus-lg float-end mt-0"> Create Airline</a>
                </div>
            </div>
            <div class="card-body">
                @if ($airlines->isEmpty())
                    <p>No airlines found.</p>
                @else
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>IATA Code</th>
                                <th>Base</th>
                                <th>Base IATA Code</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($airlines as $airline)
                                <tr>
                                    <td>{{ $airline->name }}</td>
                                    <td>{{ $airline->iata_code }}</td>
                                    <td>{{ $airline->base }}</td>
                                    <td>{{ $airline->base_iata_code }}</td>
                                    <td>
                                        <a href="{{ route('airlines.edit', $airline) }}" class="btn btn-link btn-sm bi-pencil-square"></a>
                                        <form action="{{ route('airlines.destroy', $airline) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link btn-sm text-danger bi-trash-fill"
                                                onclick="return confirm('Are you sure?')"></button>
                                        </form>
                                        <a href="{{ route('airlines.show', $airline) }}" class="btn btn-link btn-sm bi-eye-fill text-info"></a>
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
