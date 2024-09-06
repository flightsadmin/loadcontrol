@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card mt-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Cabin Zones for {{ $aircraftType->aircraft_type }}</h4>
                    <a href="{{ route('aircraft_types.cabin_zones.create', $aircraftType->id) }}"
                        class="btn btn-primary btn-sm bi-plus-lg mt-0"> Add Cabin Zone</a>
                    <a href="{{ route('aircraft_types.show', $aircraftType->id) }}"
                        class="btn btn-secondary btn-sm bi-backspace float-end mt-0"> Back</a>
                </div>
            </div>
            
            <div class="card-body">
                <ul class="list-group">
                    @forelse ($cabinZones as $zone)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-muted">
                                        <div><strong>Zone: </strong>{{ $zone->zone_name }}</div>
                                        <div><strong>Zone Capacity: </strong>{{ $zone->max_capacity }}</div>
                                        <div><strong>Index Per KG: </strong>{{ $zone->index }}</div>
                                        <div><strong>Arm: </strong>{{ $zone->arm }}</div>
                                    </span>
                                </div>
                                <div class="col-md-2 text-end">
                                    <form action="{{ route('cabin_zones.destroy', $zone->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ route('cabin_zones.edit', $zone->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @empty
                        <p>No Cabin Zones found.</p>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection
