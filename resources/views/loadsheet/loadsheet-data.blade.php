<div class="card">
    <div class="card-body">
        @php
            $passengerDistribution = json_decode($flight->loadsheet->payload_distribution, true);
            $totalPax = array_sum(
                array_filter(
                    $passengerDistribution['pax_by_type'],
                    function ($count, $type) {
                        return $type !== 'infant';
                    },
                    ARRAY_FILTER_USE_BOTH,
                ),
            );

            $zfw = $flight->registration->aircraftType->max_zero_fuel_weight - $passengerDistribution['zero_fuel_weight_actual'];
            $tow = $flight->registration->aircraftType->max_takeoff_weight - $passengerDistribution['take_off_weight_actual'];
            $ldw = $flight->registration->aircraftType->max_landing_weight - $passengerDistribution['landing_weight_actual'];

            $underload = min($zfw, $tow, $ldw);
        @endphp

        <div style="font-family: monospace;">
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
                        <td class="text-uppercase">{{ $flight->loadsheet->user->name ?? '' }}</td>
                        <td></td>
                        <td>{{ $flight->loadsheet->edition }}</td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-sm table-borderless m-0 p-0">
                <tr>
                    <td>FROM/TO</td>
                    <td>FLIGHT</td>
                    <td>A/C REG</td>
                    <td>VERSION</td>
                    <td>CREW</td>
                    <td>DATE</td>
                    <td>TIME</td>
                </tr>
                <tr>
                    <td>{{ $flight->route->origin }}/{{ $flight->route->destination }}</td>
                    <td>{{ $flight->flight_number }}</td>
                    <td>{{ $flight->registration->registration_number }}</td>
                    <td>{{ $flight->registration->aircraftType->aircraft_type }}</td>
                    <td>{{ $flight->fuelFigure->crew }}</td>
                    <td>{{ strtoupper($flight->departure->format('dMY')) }}</td>
                    <td>{{ now('Asia/Qatar')->format('Hi') }}</td>
                </tr>
            </table>
            <table class="table table-sm table-borderless mb-0">
                <tr>
                    <td style="width: 50%;">WEIGHT</td>
                    <td style="width: 50%;">DISTRIBUTION</td>
                </tr>
                <tr>
                    <td>LOAD IN COMPARTMENTS</td>
                    <td>
                        @forelse ($passengerDistribution['hold_breakdown'] as $compartment)
                            {{ ucfirst($compartment['hold_no']) }}/{{ $compartment['weight'] }}
                        @empty
                            NIL
                        @endforelse
                    </td>
                </tr>
                <tr>
                    <td>PASSENGER/CABIN BAG</td>
                    <td>
                        @forelse ($passengerDistribution['pax_by_type'] as $type => $count)
                            {{ $count . '/' }}
                        @empty
                            NIL
                        @endforelse
                        <span class="ms-3">TTL {{ $totalPax ?? 0 }}</span> CAB 0
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>Y {{ $totalPax ?? 0 }} &nbsp;&nbsp; SOC 0/0</td>
                </tr>
                <tr>
                    <td></td>
                    <td>BLKD 0</td>
                </tr>
            </table>
            <hr class="my-1">

            <table class="table table-sm table-borderless mb-0">
                <tr>
                    <td>TOTAL TRAFFIC LOAD</td>
                    <td>{{ $passengerDistribution['total_traffic_load'] }}</td>
                </tr>
                <tr>
                    <td>DRY OPERATING WEIGHT</td>
                    <td>{{ $passengerDistribution['dry_operating_weight'] }}</td>
                </tr>
                <tr>
                    <td>ZERO FUEL WEIGHT ACTUAL</td>
                    <td>{{ $passengerDistribution['zero_fuel_weight_actual'] }} &nbsp; MAX
                        {{ $flight->registration->aircraftType->max_zero_fuel_weight }} &nbsp; ADJ</td>
                </tr>
                <tr>
                    <td>TAKE OFF FUEL</td>
                    <td>{{ $passengerDistribution['take_off_fuel'] }}</td>
                </tr>
                <tr>
                    <td>TAKE OFF WEIGHT ACTUAL</td>
                    <td>{{ $passengerDistribution['take_off_weight_actual'] }} &nbsp; MAX
                        {{ $flight->registration->aircraftType->max_takeoff_weight }} &nbsp; ADJ</td>
                </tr>
                <tr>
                    <td>TRIP FUEL</td>
                    <td>{{ $passengerDistribution['trip_fuel'] }}</td>
                </tr>
                <tr>
                    <td>LANDING WEIGHT ACTUAL</td>
                    <td>{{ $passengerDistribution['landing_weight_actual'] }} &nbsp; MAX
                        {{ $flight->registration->aircraftType->max_landing_weight }} &nbsp; ADJ</td>
                </tr>
            </table>

            <hr class="my-1">
            <table class="table table-sm table-borderless mb-0">
                <tr>
                    <td>BALANCE / SEATING CONDITIONS</td>
                    <td></td>
                    <td>LAST MINUTE CHANGES</td>
                </tr>
            </table>
            <table class="table table-sm table-borderless mb-0" style="width: 50%">
                <tr>
                    <td>DOI</td>
                    <td>{{ $passengerDistribution['doi'] }}</td>
                    <td>DLI</td>
                    <td>{{ $passengerDistribution['dli'] }}</td>
                </tr>
                <tr>
                    <td>LIZFW</td>
                    <td>{{ $passengerDistribution['lizfw'] }}</td>
                    <td>LITOW</td>
                    <td>{{ $passengerDistribution['litow'] }}</td>
                </tr>
                <tr>
                    <td>MACZFW</td>
                    <td>{{ $passengerDistribution['macZFW'] }}</td>
                    <td>MACTOW</td>
                    <td>{{ $passengerDistribution['macTOW'] }}</td>
                </tr>
            </table>
            <div>STAB TRIM SETTING </div>
            <div> STAB TO 1.9 NOSE UP</div>
            <div>TRIM BY SEAT ROW</div>
            <div>
                @forelse ($passengerDistribution['zones_breakdown'] as $count)
                    {{ 'O' . $count['zone_name'] . $count['passenger_count'] . '.' }}
                @empty
                    NIL
                @endforelse
            </div>
            <table class="table table-sm table-borderless mb-0">
                <tr>
                    <td style="width: 40%">UNDERLOAD BEFORE LMC</td>
                    <td>
                        {{ $underload }}
                    </td>
                    <td>LMC TOTAL</td>
                </tr>
            </table>
            <hr class="my-1">

            <div class="mb-2">LOADMESSAGE AND CAPTAIN'S INFORMATION BEFORE LMC</div>
            <div class="mb-2">TAXI FUEL: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 200</div>

            {{-- LDM --}}
            <div>LDM </div>
            <div>
                {{ $flight->flight_number }}/{{ $flight->departure->format('d') }}.{{ $flight->registration->registration_number }}.{{ $flight->registration->aircraftType->config }}.{{ $flight->fuelFigure->crew }}
            </div>
            <div>
                -{{ $flight->route->destination }}.
                @forelse ($passengerDistribution['pax_by_type'] as $type => $count)
                    {{ $count . '/' }}
                @empty
                    NIL
                @endforelse.
                @php
                    $totalDeadload = array_sum(array_column($passengerDistribution['hold_breakdown'], 'weight'));
                @endphp
                T{{ $totalDeadload ?? 0 }}.PAX/{{ $totalPax ?? 0 }}.PAD/0
            </div>
            <div>SI PAX WEIGHTS USED
                @forelse (array_slice($passengerDistribution['passenger_weights'], 0, -1) as $type => $count)
                    {{ strtoupper($type[0]) . $count }}
                @empty
                    NIL
                @endforelse
                &nbsp; BAG WGT: ACTUAL
            </div>
            <div>{{ $flight->route->destination }}
                @forelse ($passengerDistribution['deadload_by_type'] as $type => $count)
                    {{ $type . '    ' . $count . '   ' }} &nbsp;
                @empty
                    C 0 M 0 B 0/0
                @endforelse
                O 0 &nbsp; T {{ $totalDeadload ?? 0 }}
            </div>
            <div>PANTRY CODE {{ $flight->fuelFigure->pantry }}</div>
            <div>ACTUAL LOADING OF AIRCRAFT</div>
            <div>
                @forelse ($passengerDistribution['hold_breakdown'] as $compartment)
                    <div>CPT{{ ucfirst($compartment['hold_no']) }}/{{ $compartment['weight'] }}</div>
                @empty
                    NIL
                @endforelse
            </div>
            <br>
            <div>AIRCRAFT TYPE: {{ $flight->registration->aircraftType->aircraft_type }}</div>
            <div>NOTOC: NO</div>
            <br>
            <div>{{ $flight->route->destination }} &nbsp;&nbsp;
                @forelse ($passengerDistribution['deadload_by_type'] as $type => $count)
                    {{ $type . '    ' . $count . '   ' }} &nbsp;&nbsp;&nbsp;&nbsp;
                @empty
                    C 0 M 0 B 0/0
                @endforelse
                TRA 0
            </div>
            <div>END LOADSHEET EDNO {{ $flight->loadsheet->edition }} -
                {{ $flight->flight_number }}/{{ $flight->departure->format('d') }}
                &nbsp;&nbsp;&nbsp;&nbsp; {{ $flight->departure }}
            </div>
        </div>
    </div>
</div>
