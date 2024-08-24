@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        @isset($flight)
            <div class="card mt-4">
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between align-items-center mb-2 border-bottom">
                            <h5 class="mb-0">Flight Number: {{ $flight->flight_number }}</h5>
                            <a href="{{ route('flights.edit', $flight->id) }}" class="btn btn-sm btn-warning">Edit Flight</a>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <p class="card-text"><strong>Departure:</strong> {{ $flight->departure }}</p>
                                <p class="card-text"><strong>Arrival:</strong> {{ $flight->arrival }}</p>
                                <p class="card-text"><strong>Registration:</strong> {{ $flight->registration->registration }}
                                    <a href="{{ route('registrations.edit', $flight->registration->id) }}" class="btn btn-sm btn-primary">Edit
                                        Registration</a>
                                </p>
                                <p>Total Weight: {{ round($totalWeight, 0) }} Kgs</p>
                            </div>
                            <div class="col-md-8">
                                <div class="hold-figure">
                                    @foreach ($flight->registration->holds as $hold)
                                        <div class="hold"
                                            style="top: 0; left: {{ $hold->fwd }}%; width: {{ $hold->aft - $hold->fwd }}%; height: 100%; background-color: grey; border: 1px solid #6c757d; position: absolute;">
                                            <span class="text-white">{{ $hold->hold_no }}</span>

                                            @foreach ($flight->cargos->where('hold_id', $hold->id) as $cargo)
                                                <div class="cargo"
                                                    style="position: absolute; bottom: {{ 5 + $loop->index * 30 }}px; left: 5px; font-size: 0.8rem;">
                                                    <span class="badge bg-primary">{{ $cargo->type }}</span>
                                                    <span class="text-white">{{ $cargo->weight }} kg</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5>Loaded Cargo</h5>
                            <a href="{{ route('flights.cargos.create', $flight->id) }}" class="btn btn-primary btn-sm">Add Deadload</a>
                        </div>
                        <ul class="list-group">
                            @forelse($flight->cargos as $cargo)
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            {{ ucfirst($cargo->type) }}, {{ $cargo->pieces }} pcs, {{ $cargo->weight }} kg, Loaded:
                                            {{ $cargo->hold->hold_no ?? 'Unplanned' }}
                                        </div>
                                        <div>
                                            <a href="{{ route('cargos.edit', $cargo->id) }}" class="btn btn-warning btn-sm me-2 pencil-square"> Edit</a>
                                            <form action="{{ route('cargos.destroy', $cargo->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
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
        @else
            <p class="mt-4">Select a flight from the sidebar to view details.</p>
        @endisset
    </div>

    <style>
        .hold-figure {
            position: relative;
            width: 100%;
            height: 150px;
            border: 1px solid #ddd;
            background-color: #f8f9fa;
            margin-top: 20px;
            margin-bottom: 20px;
            overflow: auto;
        }

        .hold {
            position: absolute;
            box-sizing: border-box;
            height: 100%;
        }

        .cargo {
            font-size: 0.8rem;
            background: rgba(0, 0, 0, 0.6);
            padding: 2px 5px;
            border-radius: 3px;
            color: #fff;
        }
    </style>
@endsection
