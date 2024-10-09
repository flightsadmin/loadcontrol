@if ($flight->loadsheet)
    <div class="container-fluid">
        <div style="font-family: monospace;">
            <div>LDM </div>
            <div>
                {{ $flight->flight_number }}/{{ $flight->departure->format('d') }}.{{ $flight->registration->registration_number }}.{{ $flight->registration->aircraftType->config }}.{{ $flight->fuelFigure->crew }}
            </div>
            <div>
                -{{ $flight->route->destination }}.
                @forelse (json_decode($flight->loadsheet->passenger_distribution, true)['pax'] as $type => $count)
                    {{ $count . '/' }}
                @empty
                    NIL
                @endforelse.
                @php
                    $totalDeadload = array_sum(array_column(json_decode($flight->loadsheet->compartment_loads, true), 'weight'));
                @endphp
                T{{ $totalDeadload ?? 0 }}.PAX/{{ $passengerDistribution ?? 0 }}.PAD/0
            </div>
            <div>SI PAX WEIGHTS USED
                {{ 'M' .
                    $flight->airline->settings['passenger_weights']['male'] .
                    ' F' .
                    $flight->airline->settings['passenger_weights']['female'] .
                    ' C' .
                    $flight->airline->settings['passenger_weights']['child'] .
                    ' I' .
                    $flight->airline->settings['passenger_weights']['infant'] }}
                &nbsp;&nbsp;&nbsp; BAG WGT: ACTUAL
            </div>
            <div>{{ $flight->route->destination }} C {{ $totalDeadload ?? 0 }} M 0 B 0/ 0 O 0 T
                {{ $totalDeadload ?? 0 }}
            </div>
            <div>PANTRY CODE {{ $flight->fuelFigure->pantry }}</div>
            <div>ACTUAL LOADING OF AIRCRAFT</div>
            <div>
                @forelse (json_decode($flight->loadsheet->compartment_loads, true) as $compartment)
                    <div>CPT{{ ucfirst($compartment['hold_no']) }}/{{ $compartment['weight'] }}</div>
                @empty
                    NIL
                @endforelse
            </div>
            <br>
            <div>AIRCRAFT TYPE: {{ $flight->registration->aircraftType->aircraft_type }}</div>
            <div>NOTOC: NO</div>
            <br>
            <div>{{ $flight->route->destination }} &nbsp;&nbsp; FRE 0 &nbsp;&nbsp; POS 0 &nbsp;&nbsp; BAG 0/0
                &nbsp;&nbsp; TRA
                0</div>
        </div>
    @else
        <div class="container mb-3">
            <p>Loadsheet not Finalised</p>
        </div>
@endif
