@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card my-3">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Load and Trim Sheet</h4>
                    <a href="{{ route('flights.show', ['flight' => $flight->id, 'tab' => 'cargo']) }}"
                        class="btn btn-secondary btn-sm bi-backspace float-end mt-0"> Back</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
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
                                                <td>{{ strtoupper(auth()->user()->name) }}</td>
                                                <td></td>
                                                <td>1</td>
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
                                            <td>{{ $flight->origin }}/{{ $flight->destination }}</td>
                                            <td>{{ $flight->flight_number }}</td>
                                            <td>{{ $flight->registration->registration_number }}</td>
                                            <td>{{ $flight->registration->aircraftType->aircraft_type }}</td>
                                            <td>{{ $flight->fuelFigure->crew }}</td>
                                            <td>{{ strtoupper($flight->departure->format('dMY')) }}</td>
                                            <td>{{ $flight->departure->format('Hs') }}</td>
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
                                                @forelse (json_decode($flight->loadsheet->compartment_loads, true) as $compartment)
                                                    {{ ucfirst($compartment['hold_no']) }}/{{ $compartment['weight'] }}
                                                @empty
                                                    NIL
                                                @endforelse
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>PASSENGER/CABIN BAG</td>
                                            <td>
                                                @forelse (json_decode($flight->loadsheet->passenger_distribution, true)['pax'] as $type => $count)
                                                    {{ $count . '/' }}
                                                @empty
                                                    NIL
                                                @endforelse
                                                @php
                                                    $passengerDistribution = array_sum(
                                                        json_decode($flight->loadsheet->passenger_distribution, true)['pax'],
                                                    );
                                                @endphp
                                                <span class="ms-3">TTL {{ $passengerDistribution ?? 0 }}</span> CAB 0
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>JY 0/1 &nbsp;&nbsp; SOC 0/0</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>BLKD 0</td>
                                        </tr>
                                    </table>
                                    <div style="width: 100%">****************************************************************</div>

                                    <table class="table table-sm table-borderless mb-0">
                                        <tr>
                                            <td>TOTAL TRAFFIC LOAD</td>
                                            <td>{{ $flight->loadsheet->total_traffic_load }}</td>
                                        </tr>
                                        <tr>
                                            <td>DRY OPERATING WEIGHT</td>
                                            <td>{{ $flight->loadsheet->dry_operating_weight }}</td>
                                        </tr>
                                        <tr>
                                            <td>ZERO FUEL WEIGHT ACTUAL</td>
                                            <td>{{ $flight->loadsheet->zero_fuel_weight_actual }} &nbsp; MAX 64300 &nbsp; ADJ</td>
                                        </tr>
                                        <tr>
                                            <td>TAKE OFF FUEL</td>
                                            <td>{{ $flight->loadsheet->take_off_fuel }}</td>
                                        </tr>
                                        <tr>
                                            <td>TAKE OFF WEIGHT ACTUAL</td>
                                            <td>{{ $flight->loadsheet->take_off_weight_actual }} &nbsp; MAX 79000 &nbsp; ADJ</td>
                                        </tr>
                                        <tr>
                                            <td>TRIP FUEL</td>
                                            <td>{{ $flight->loadsheet->trip_fuel }}</td>
                                        </tr>
                                        <tr>
                                            <td>LANDING WEIGHT ACTUAL</td>
                                            <td>{{ $flight->loadsheet->landing_weight_actual }} &nbsp; MAX 67400 &nbsp; ADJ</td>
                                        </tr>
                                    </table>

                                    <div>****************************************************************</div>
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
                                            <td>51.2</td>
                                            <td>DLI</td>
                                            <td>51.2</td>
                                        </tr>
                                        <tr>
                                            <td>LIZFW</td>
                                            <td>50.6</td>
                                            <td>LITOW</td>
                                            <td>47.7</td>
                                        </tr>
                                        <tr>
                                            <td>MACZFW</td>
                                            <td>{{ $macZFW }}</td>
                                            <td>MACTOW</td>
                                            <td>{{ $macTOW }}</td>
                                        </tr>
                                    </table>
                                    <div>STAB TRIM SETTING </div>
                                    <div> STAB TO 1.9 NOSE UP</div>
                                    <div>TRIM BY SEAT ROW</div>
                                    <div>0A1.0B0.0C0.</div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>UNDERLOAD BEFORE LMC &nbsp;&nbsp;&nbsp;&nbsp; 19716</div>
                                        <div>LMC TOTAL</div>
                                    </div>
                                    <div>****************************************************************</div>
                                    <div>LOADMESSAGE AND CAPTAIN'S INFORMATION BEFORE LMC</div>
                                    <div>TAXI FUEL: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 200</div>

                                    <table class="table table-sm table-borderless mb-0" style="width: 60%">
                                        <tr>
                                            <td>CG LIMITS</td>
                                            <td>LITOW</td>
                                            <td>FWD 33.43</td>
                                            <td>AFT 72.18</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>MACTOW</td>
                                            <td>FWD 17.55</td>
                                            <td>AFT 34.98</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>LIZFW</td>
                                            <td>FWD 38.75</td>
                                            <td>AFT 60.72</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>MACZFW</td>
                                            <td>FWD 18.98</td>
                                            <td>AFT 30.73</td>
                                        </tr>
                                    </table>

                                    <br>
                                    <div>LDM
                                        {{ $flight->flight_number }}/{{ $flight->departure->format('d') }}.{{ $flight->registration->registration_number }}.J04Y174.{{ $flight->fuelFigure->crew }}
                                    </div>
                                    <div>
                                        -{{ $flight->destination }}.
                                        @forelse (json_decode($flight->loadsheet->passenger_distribution, true)['pax'] as $type => $count)
                                            {{ $count . '/' }}
                                        @empty
                                            NIL
                                        @endforelse.
                                        @php
                                            $totalDeadload = array_sum(
                                                array_column(json_decode($flight->loadsheet->compartment_loads, true), 'weight'),
                                            );
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
                                    <div>{{ $flight->destination }} C {{ $totalDeadload ?? 0 }} M 0 B 0/ 0 O 0 T {{ $totalDeadload ?? 0 }}
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
                                    <div>AIRCRAFT TYPE: {{ $flight->registration->aircraftType->aircraft_type }}</div>
                                    <div>NOTOC: NO</div>
                                    <div>MCT &nbsp;&nbsp; FRE 0 &nbsp;&nbsp; POS 0 &nbsp;&nbsp; BAG 0/0 &nbsp;&nbsp; TRA 0</div>

                                    <div>END LOADSHEET EDNO 1 - {{ $flight->flight_number }}/{{ $flight->departure->format('d') }}
                                        &nbsp;&nbsp;&nbsp;&nbsp; {{ $flight->departure }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <canvas id="trimSheetChart" height="220"></canvas>
                                <div class="mx-4">
                                    <div class="d-flex justify-content-between align-items-center mx-4">
                                        <div>MACZFW <span class="text-danger">{{ $macZFW }}%</span></div>
                                        <div>MACTOW <span class="text-primary">{{ $macTOW }}%</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const zfwEnvelopeData = @json($zfwEnvelope);
        const towEnvelopeData = @json($towEnvelope);
        const ctx = document.getElementById('trimSheetChart').getContext('2d');
        const trimSheetChart = new Chart(ctx, {
            type: 'scatter',
            data: {
                datasets: [{
                        label: 'ZFW Envelope',
                        data: zfwEnvelopeData,
                        borderColor: 'red',
                        showLine: true,
                        pointRadius: 0,
                        fill: false,
                    },
                    {
                        label: 'TOW Envelope',
                        data: towEnvelopeData,
                        borderColor: 'blue',
                        showLine: true,
                        pointRadius: 0,
                        fill: false,
                    },
                    {
                        label: 'ZFW',
                        data: [{
                            x: {{ $lizfw }},
                            y: {{ $flight->loadsheet->zero_fuel_weight_actual / 1000 ?? 0 }}
                        }],
                        backgroundColor: 'red',
                        pointRadius: 4
                    },
                    {
                        label: 'TOW',
                        data: [{
                            x: {{ $litow }},
                            y: {{ $flight->loadsheet->take_off_weight_actual / 1000 ?? 0 }}
                        }],
                        backgroundColor: 'blue',
                        pointRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        type: 'linear',
                        title: {
                            display: true,
                            text: 'Index (% MAC)'
                        },
                        min: 25,
                        max: 100
                    },
                    y: {
                        type: 'linear',
                        title: {
                            display: true,
                            text: 'Aircraft Weight (kg x 1000)'
                        },
                        min: 40.6,
                        max: 85
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += '(Index ' + (context.raw.x).toFixed(2) + ', Weight ' + (context.raw.y * 1000)
                                    .toLocaleString() + ' kg)';
                                return label;
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection
