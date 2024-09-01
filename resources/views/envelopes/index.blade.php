@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Envelopes for Registration: {{ $registration->registration_number }}</h2>
    <a href="{{ route('registrations.envelopes.create', $registration) }}" class="btn btn-primary mb-3">Create Envelope</a>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>Type</th>
                <th>X</th>
                <th>Y</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($envelopes as $envelope)
                <tr>
                    <td>{{ $envelope->envelope_type }}</td>
                    <td>{{ $envelope->x }}</td>
                    <td>{{ $envelope->y }}</td>
                    <td>
                        <a href="{{ route('registrations.envelopes.edit', [$registration, $envelope]) }}" class="btn btn-sm btn-link">Edit</a>
                        <form action="{{ route('registrations.envelopes.destroy', [$registration, $envelope]) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-link" onclick="return confirm('Are you sure?')">Delete</button>
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
@endsection
