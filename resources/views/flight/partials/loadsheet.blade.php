@if ($flight->loadsheet)
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-sm table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <td>LOADSHEET</td>
                                    <td>CHECKED</td>
                                    <td>APPROVED</td>
                                    <td>EDNO</td>
                                </tr>
                                <tr>
                                    <td>ALL WEIGHTS IN KILOS</td>
                                    <td>{{ strtoupper(auth()->user()->name) }}</td>
                                    <td>NIL</td>
                                    <td>1</td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-sm table-borderless mb-1">
                            <tbody>
                                <tr>
                                    <td>FROM/TO</td>
                                    <td>FLIGHT</td>
                                    <td>REG</td>
                                    <td>VER</td>
                                    <td>CREW</td>
                                    <td>DATE</td>
                                    <td>TIME</td>
                                </tr>
                                <tr>
                                    <td>{{ $flight->origin }} {{ $flight->destination }}</td>
                                    <td>{{ $flight->flight_number }}</td>
                                    <td>{{ strtoupper($flight->registration->registration_number) }}</td>
                                    <td></td>
                                    <td>{{ $flight->fuelFigure->crew ?? "0/0"}}</td>
                                    <td>{{ strtoupper($flight->departure->format('dMY')) }}</td>
                                    <td>{{ now()->format('hi') }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <dl class="row">
                            <dd class="col-sm-5 text-uppercase">LOAD IN COMPARTMENTS</dd>
                            <dd class="col-sm-7">
                                @forelse (json_decode($flight->loadsheet->compartment_loads, true) as $compartment)
                                    {{ ucfirst($compartment['hold_no']) }}/{{ $compartment['weight'] }}
                                @empty
                                    NIL
                                @endforelse
                            </dd>

                            <dd class="col-sm-5 text-uppercase">Passenger / Cabin Bag</dd>
                            <dd class="col-sm-7 text-uppercase">
                                @forelse (json_decode($flight->loadsheet->passenger_distribution, true)['pax'] as $type => $count)
                                    {{ $count . '/' }}
                                @empty
                                    NIL
                                @endforelse
                                @php
                                    $passengerDistribution = array_sum(json_decode($flight->loadsheet->passenger_distribution, true)['pax']);
                                @endphp

                                @if ($passengerDistribution > 0)
                                    <span class="ms-3">TTL {{ $passengerDistribution }}</span>
                                @else
                                    0
                                @endif
                            </dd>

                            <dd class="col-sm-5 text-uppercase">Total Traffic Load</dd>
                            <dd class="col-sm-7 text-uppercase">{{ $flight->loadsheet->total_traffic_load }}</dd>

                            <dd class="col-sm-5 text-uppercase">Dry Operating Weight</dd>
                            <dd class="col-sm-7 text-uppercase">{{ $flight->loadsheet->dry_operating_weight }}</dd>

                            <dd class="col-sm-5 text-uppercase">Zero Fuel Weight Actual</dd>
                            <dd class="col-sm-7 text-uppercase d-flex align-items-center">
                                {{ $flight->loadsheet->zero_fuel_weight_actual }}
                                <span class="ms-3">MAX
                                    {{ $flight->registration->aircraftType->max_zero_fuel_weight }}</span>
                                <span class="ms-4">ADJ</span>
                            </dd>

                            <dd class="col-sm-5 text-uppercase">Takeoff Fuel</dd>
                            <dd class="col-sm-7 text-uppercase">{{ $flight->loadsheet->take_off_fuel }}</dd>

                            <dd class="col-sm-5 text-uppercase">Takeoff Weight Actual</dd>
                            <dd class="col-sm-7 text-uppercase d-flex align-items-center">
                                {{ $flight->loadsheet->take_off_weight_actual }}
                                <span class="ms-3">MAX {{ $flight->registration->aircraftType->max_takeoff_weight }}</span>
                                <span class="ms-4">ADJ</span>
                            </dd>

                            <dd class="col-sm-5 text-uppercase">Trip Fuel</dd>
                            <dd class="col-sm-7 text-uppercase">{{ $flight->loadsheet->trip_fuel }}</dd>

                            <dd class="col-sm-5 text-uppercase">Landing Weight Actual</dd>
                            <dd class="col-sm-7 text-uppercase d-flex align-items-center">
                                {{ $flight->loadsheet->landing_weight_actual }}
                                <span class="ms-3">MAX {{ $flight->registration->aircraftType->max_landing_weight }}</span>
                                <span class="ms-4">ADJ</span>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="container mb-3">
        <p>No Load Sheet Created</p>
    </div>
@endif
