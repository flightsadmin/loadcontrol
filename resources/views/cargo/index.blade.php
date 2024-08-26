@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="mb-4">Cargo for Flight: {{ $flight->flight_number }}</h5>

                <ul class="list-group">
                    @forelse($flight->cargos as $cargo)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    {{ ucfirst($cargo->type) }}, {{ $cargo->pieces }} pcs, {{ $cargo->weight }} kg, Loaded:
                                    {{ $cargo->hold->hold_no ?? 'Unplanned' }}
                                </div>
                                <div>
                                    <a href="{{ route('cargos.edit', $cargo->id) }}"
                                        class="btn btn-warning btn-sm me-2 bi-pencil-square"></a>
                                    <form action="{{ route('cargos.destroy', $cargo->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm bi-trash-fill"></button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item">No cargo planned.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection
