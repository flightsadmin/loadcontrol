@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Airlines</h1>
    <a href="{{ route('airlines.create') }}" class="btn btn-primary mb-3">Create Airline</a>
    @if ($airlines->isEmpty())
        <p>No airlines found.</p>
    @else
        <table class="table table-striped">
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
                            <a href="{{ route('airlines.edit', $airline) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('airlines.destroy', $airline) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                            <a href="{{ route('airlines.show', $airline) }}" class="btn btn-info btn-sm">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
