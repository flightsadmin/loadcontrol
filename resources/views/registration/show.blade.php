@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="mt-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">
                    <a href="{{ route('registrations.index') }}" class="text-decoration-none">
                        {{ $registration->registration }}
                    </a>
                </h4>
                <div>
                    <a href="{{ route('registrations.edit', $registration->id) }}" class="btn btn-warning btn-sm">Edit Registration</a>
                    <form action="{{ route('registrations.destroy', $registration->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete Registration</button>
                    </form>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="mb-3"><strong>Max Takeoff Weight:</strong> {{ $registration->max_takeoff_weight }} kg</div>
                    <div class="mb-3"><strong>Empty Weight:</strong> {{ $registration->empty_weight }} kg</div>
                    <div class="mb-3"><strong>Fuel Capacity:</strong> {{ $registration->fuel_capacity }}</div>
                    <div class="mb-3"><strong>CG Range:</strong> {{ $registration->cg_range_min }} - {{ $registration->cg_range_max }}</div>
                </div>
                <div class="col-md-8">
                    <div class="hold-figure">
                        @foreach ($holds as $hold)
                            <div class="hold"
                                style="left: {{ $hold->fwd }}%; width: {{ $hold->aft - $hold->fwd }}%; background-color: rgba(0, 123, 255, 0.5); border: 1px solid #007bff;">
                                <span class="text-white">{{ $hold->hold_no }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">Holds</h4>
                <a href="{{ route('registrations.holds.create', $registration->id) }}" class="btn btn-primary btn-sm">Add Hold</a>
            </div>

            <!-- List of holds -->
            <ul class="list-group">
                @forelse ($registration->holds as $hold)
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $hold->hold_no }}</strong>
                                <span class="text-muted">FWD: {{ $hold->fwd }}m, AFT: {{ $hold->aft }}m</span>
                                <div>Restrictions: {{ $hold->restrictions ?? 'None' }}</div>
                            </div>
                            <div>
                                <a href="{{ route('holds.edit', $hold->id) }}" class="btn btn-warning btn-sm me-2">Edit</a>
                                <form action="{{ route('holds.destroy', $hold->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                    </li>
                @empty
                    <p>No holds available for this registration.</p>
                @endforelse
            </ul>
        </div>

        <style>
            .hold-figure {
                position: relative;
                width: 100%;
                height: 100px;
                border: 1px solid #ddd;
                background-color: #f8f9fa;
                margin-top: 20px;
                overflow: hidden;
            }

            .hold {
                position: absolute;
                box-sizing: border-box;
                height: 100%;
            }

            .hold span {
                position: absolute;
                bottom: 10px;
                left: 10px;
                font-size: 0.8rem;
                background: rgba(0, 0, 0, 0.6);
                padding: 2px 5px;
                border-radius: 3px;
            }
        </style>
    </div>
@endsection
