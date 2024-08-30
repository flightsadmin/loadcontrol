@if ($flight->loadsheet)
    {{-- <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <a href="{{route('flights.loadsheets.show', ['flight' => $flight, 'loadsheet' => $flight->loadsheet])}}"> View Loadsheet</a>
                <div class="col-sm-7 d-flex justify-content-between">
                    <span>LOADSHEET</span>
                    <span>FINAL</span>
                    <span>{{ now()->format('hi') }}</span>
                    <span>ED NO 1</span>
                </div>
                <div class="col-sm-7 d-flex justify-content-between">
                    <span>{{ $flight->flight_number }}/{{ $flight->departure->format('d') }}</span>
                    <span>{{ strtoupper($flight->registration->registration) }}</span>
                    <span>{{ strtoupper($flight->departure->format('dMY')) }}</span>
                    <span></span>
                </div>
            </div>

            <dl class="row">
                <dt class="col-sm-4">Passenger / Cabin Bag</dt>
                <dd class="col-sm-8">
                    @forelse (json_decode($flight->loadsheet->passenger_distribution, true) as $type => $count)
                        {{ $count . '/' }}
                    @empty
                        Nil
                    @endforelse
                    <span class="ms-3">TTL</span>
                </dd>

                <dt class="col-sm-4">Total Traffic Load</dt>
                <dd class="col-sm-8">{{ $flight->loadsheet->total_traffic_load }}</dd>

                <dt class="col-sm-4">Dry Operating Weight</dt>
                <dd class="col-sm-8">{{ $flight->loadsheet->dry_operating_weight }}</dd>

                <dt class="col-sm-4">Zero Fuel Weight Actual</dt>
                <dd class="col-sm-8 d-flex align-items-center">
                    {{ $flight->loadsheet->zero_fuel_weight_actual }}
                    <span class="ms-3 text-muted">MAX {{ $flight->registration->max_takeoff_weight }}</span>
                    <span class="ms-4 text-muted">ADJ</span>
                </dd>

                <dt class="col-sm-4">Takeoff Fuel</dt>
                <dd class="col-sm-8">{{ $flight->loadsheet->take_off_fuel }}</dd>

                <dt class="col-sm-4">Takeoff Weight Actual</dt>
                <dd class="col-sm-8 d-flex align-items-center">
                    {{ $flight->loadsheet->take_off_weight_actual }}
                    <span class="ms-3 text-muted">MAX {{ $flight->registration->max_takeoff_weight }}</span>
                    <span class="ms-4 text-muted">ADJ</span>
                </dd>

                <dt class="col-sm-4">Trip Fuel</dt>
                <dd class="col-sm-8">{{ $flight->loadsheet->trip_fuel }}</dd>

                <dt class="col-sm-4">Landing Weight Actual</dt>
                <dd class="col-sm-8 d-flex align-items-center">
                    {{ $flight->loadsheet->landing_weight_actual }}
                    <span class="ms-3 text-muted">MAX {{ $flight->registration->max_takeoff_weight }}</span>
                    <span class="ms-4 text-muted">ADJ</span>
                </dd>

                <dt class="col-sm-4">Compartment Loads</dt>
                <dd class="col-sm-8">
                    @forelse (json_decode($flight->loadsheet->compartment_loads, true) as $compartment => $weight)
                        {{ ucfirst($compartment) }}: {{ $weight }}<br>
                    @empty
                        Nil
                    @endforelse
                </dd>
            </dl>

            <div class="row mt-3">
                <div class="col-sm-6">
                    <p class="text-center">BALANCE / SEATING CONDITIONS</p>
                    <dl class="row">
                        <dt class="col-sm-4">DOI</dt>
                        <dd class="col-sm-8">{{ $flight->loadsheet->doi ?? 'Not Available' }}</dd>

                        <dt class="col-sm-4">DLI</dt>
                        <dd class="col-sm-8">{{ $flight->loadsheet->dli ?? 'Not Available' }}</dd>

                        <dt class="col-sm-4">LIZFW</dt>
                        <dd class="col-sm-8">{{ $flight->loadsheet->lizfw ?? 'Not Available' }}</dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-sm-4">LITOW</dt>
                        <dd class="col-sm-8">{{ $flight->loadsheet->litow ?? 'Not Available' }}</dd>

                        <dt class="col-sm-4">MACZFW</dt>
                        <dd class="col-sm-8">{{ $flight->loadsheet->maczfw ?? 'Not Available' }}</dd>

                        <dt class="col-sm-4">MACTOW</dt>
                        <dd class="col-sm-8">{{ $flight->loadsheet->mactow ?? 'Not Available' }}</dd>
                    </dl>
                    <div class="col-sm-12">UNDERLOAD BEFORE LMC {{ $lmc ?? 0 }}</div>
                </div>

                <div class="col-sm-6 border-start border-top d-flex flex-column justify-content-between">
                    <div>
                        <p class="text-center m-0">LAST MINUTE CHANGES</p>
                        <dl class="row">
                            <div class="col-sm-3">DEST</div>
                            <div class="col-sm-3">SPEC</div>
                            <div class="col-sm-3">CL/CPT</div>
                            <div class="col-sm-3">WEIGHT - ADJ</div>
                        </dl>
                    </div>
                    <div class="col-sm-12 text-center">UNDERLOAD BEFORE LMC {{ $lmc ?? 0 }}</div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-sm-12">
                    <p class="text-center">STAB TRIM SETTING</p>
                    <dl class="row">
                        <dt class="col-sm-4">STAB TO</dt>
                        <dd class="col-sm-8">{{ $flight->loadsheet->stab_to ?? 'Not Available' }}</dd>

                        <dt class="col-sm-4">TRIM BY SEAT ROW</dt>
                        <dd class="col-sm-8">{{ $flight->loadsheet->trim_by_seat_row ?? 'Not Available' }}</dd>
                    </dl>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-sm-12">
                    <p class="text-center">LOAD MESSAGE AND CAPTAIN'S INFORMATION BEFORE LMC</p>
                    <dl class="row">
                        <dt class="col-sm-4">Load Message</dt>
                        <dd class="col-sm-8">{{ $flight->loadsheet->load_message ?? 'Not Available' }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-sm mb-0">
                            <tbody>
                                <tr>
                                    <td>LOADSHEET</td>
                                    <td>CHECKED</td>
                                    <td>APPROVED</td>
                                    <td>EDNO</td>
                                </tr>
                                <tr>
                                    <td>ALL WEIGHTS IN KILOS</td>
                                    <td>{{ auth()->user()->name }}</td>
                                    <td>NIL</td>
                                    <td>1</td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-sm mb-1">
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
                                    <td>{{ strtoupper($flight->registration->registration) }}</td>
                                    <td></td>
                                    <td>{{ $flight->fuelFigure->crew }}</td>
                                    <td>{{ strtoupper($flight->departure->format('dMY')) }}</td>
                                    <td>{{ now()->format('hi') }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <dl class="row">
                            <dt class="col-sm-4">Passenger / Cabin Bag</dt>
                            <dd class="col-sm-8">
                                @forelse (json_decode($flight->loadsheet->passenger_distribution, true) as $type => $count)
                                    {{ $count . '/' }}
                                @empty
                                    Nil
                                @endforelse
                                <span class="ms-3">TTL</span>
                            </dd>

                            <dt class="col-sm-4">Total Traffic Load</dt>
                            <dd class="col-sm-8">{{ $flight->loadsheet->total_traffic_load }}</dd>

                            <dt class="col-sm-4">Dry Operating Weight</dt>
                            <dd class="col-sm-8">{{ $flight->loadsheet->dry_operating_weight }}</dd>

                            <dt class="col-sm-4">Zero Fuel Weight Actual</dt>
                            <dd class="col-sm-8 d-flex align-items-center">
                                {{ $flight->loadsheet->zero_fuel_weight_actual }}
                                <span class="ms-3 text-muted">MAX {{ $flight->registration->max_zero_fuel_weight }}</span>
                                <span class="ms-4 text-muted">ADJ</span>
                            </dd>

                            <dt class="col-sm-4">Takeoff Fuel</dt>
                            <dd class="col-sm-8">{{ $flight->loadsheet->take_off_fuel }}</dd>

                            <dt class="col-sm-4">Takeoff Weight Actual</dt>
                            <dd class="col-sm-8 d-flex align-items-center">
                                {{ $flight->loadsheet->take_off_weight_actual }}
                                <span class="ms-3 text-muted">MAX {{ $flight->registration->max_takeoff_weight }}</span>
                                <span class="ms-4 text-muted">ADJ</span>
                            </dd>

                            <dt class="col-sm-4">Trip Fuel</dt>
                            <dd class="col-sm-8">{{ $flight->loadsheet->trip_fuel }}</dd>

                            <dt class="col-sm-4">Landing Weight Actual</dt>
                            <dd class="col-sm-8 d-flex align-items-center">
                                {{ $flight->loadsheet->landing_weight_actual }}
                                <span class="ms-3 text-muted">MAX {{ $flight->registration->max_landing_weight }}</span>
                                <span class="ms-4 text-muted">ADJ</span>
                            </dd>

                            <dt class="col-sm-4">Compartment Loads</dt>
                            <dd class="col-sm-8">
                                @forelse (json_decode($flight->loadsheet->compartment_loads, true) as $compartment => $weight)
                                    {{ ucfirst($compartment) }}: {{ $weight }}<br>
                                @empty
                                    Nil
                                @endforelse
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            {{-- <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <canvas id="trimSheetChart"></canvas>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
@else
    <div class="container mb-3">
        <p>No Load Sheet Created</p>
    </div>
@endif
