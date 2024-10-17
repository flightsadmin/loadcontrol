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
            <div class="mb-2">TAXI FUEL: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $passengerDistribution['taxi_fuel'] }}</div>

            {{-- LDM --}}
            @include('loadsheet.ldm-data')

            <div>END LOADSHEET EDNO {{ $flight->loadsheet->edition }} -
                {{ $flight->flight_number }}/{{ $flight->departure->format('d') }}
                &nbsp;&nbsp;&nbsp;&nbsp; {{ $flight->departure }}
            </div>
        </div>
    </div>
</div>
