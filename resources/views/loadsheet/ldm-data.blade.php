<div style="font-family: monospace;">
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
    @endphp

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
</div>
