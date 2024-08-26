@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="mb-4">Passengers for Flight: {{ $flight->flight_number }}</h5>
            <table class="table table-bordered table-sm text-center">
                <thead>
                    <tr>
                        <th>Zone</th>
                        <th>Male</th>
                        <th>Female</th>
                        <th>Children</th>
                        <th>Infants</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (range(1, 4) as $zone)
                        <tr>
                            <td>Zone {{ $zone }}</td>
                            @foreach (['male', 'female', 'child', 'infant'] as $type)
                                <td>
                                    @php
                                        $count = $flight->passengers->where('zone', $zone)->where('type', $type)->sum('count');
                                    @endphp
                                    {{ $count }}
                                </td>
                            @endforeach
                            <td class="fw-bold">
                                @php
                                    $total = $flight->passengers->where('zone', $zone)->sum('count');
                                @endphp
                                {{ $total }}
                            </td>
                            <td>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addPassengerModal"
                                    data-zone="{{ $zone }}">Add/Update</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Total</th>
                        @foreach (['male', 'female', 'child', 'infant'] as $type)
                            <th>
                                @php
                                    $totalType = $flight->passengers->where('type', $type)->sum('count');
                                @endphp
                                {{ $totalType }}
                            </th>
                        @endforeach
                        <th>
                            @php
                                $totalCount = $flight->passengers->sum('count');
                            @endphp
                            {{ $totalCount }}
                        </th>
                        <td></td>
                    </tr>
                </tfoot>
            </table>

            <div class="modal fade" id="addPassengerModal" tabindex="-1" aria-labelledby="addPassengerModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addPassengerModalLabel">Update Passenger</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="passengerForm" action="{{ route('flights.passengers.store', $flight->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="zone" id="zoneInput">
                                <div class="mb-3">
                                    <label for="type" class="form-label">Type</label>
                                    <select class="form-control" name="type" id="type" required>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="child">Child</option>
                                        <option value="infant">Infant</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="count" class="form-label">Count</label>
                                    <input type="number" class="form-control" name="count" id="count" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var passengerModal = document.getElementById('addPassengerModal');
        passengerModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget; // Button that triggered the modal
            var zone = button.getAttribute('data-zone'); // Extract info from data-* attributes

            var modalTitle = passengerModal.querySelector('.modal-title');
            var zoneInput = passengerModal.querySelector('#zoneInput');

            modalTitle.textContent = 'Add/Update Passengers for Zone ' + zone;
            zoneInput.value = zone;
        });
    });
</script>
@endsection
