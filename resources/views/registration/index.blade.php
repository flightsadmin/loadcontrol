@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center m-0">
                    <h4>Aircraft Registrations</h4>
                    <a href="{{ route('registrations.create') }}" class="btn btn-sm btn-primary bi-plus-circle"> Add Registration</a>
                </div>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @forelse ($registrations as $registration)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span>{{ $registration->registration }}</span>
                                    <span class="text-muted">
                                        <span><strong>MTOW: </strong>{{ $registration->max_takeoff_weight }}Kgs</span>
                                        <span><strong>Basic Weight: </strong>{{ $registration->basic_weight }}Kgs</span>
                                        <span><strong>Fuel Capacity: </strong>{{ $registration->fuel_capacity }}Kgs</span>
                                        <span><strong>CG Margins: </strong>{{ $registration->cg_range_min }} -
                                            {{ $registration->cg_range_max }}</span>
                                    </span>
                                </div>
                                <div>
                                    <a href="{{ route('registrations.show', $registration->id) }}" class="btn btn-sm btn-info">View</a>
                                </div>
                            </div>
                        </li>
                    @empty
                        <p>No registrations available.</p>
                    @endforelse
                </ul>
                <div class="mt-3 float-end">
                    {{ $registrations->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
