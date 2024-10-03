@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card mt-4">
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
                                            <td>{{ $flight->fuelFigure->crew }}</td>
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
                                            $passengerDistribution = array_sum(
                                                json_decode($flight->loadsheet->passenger_distribution, true)['pax'],
                                            );
                                        @endphp
                                        <span class="ms-3">TTL {{ $passengerDistribution ?? 0 }}</span>
                                    </dd>

                                    <dd class="col-sm-5 text-uppercase">Total Traffic Load</dd>
                                    <dd class="col-sm-7 text-uppercase">{{ $flight->loadsheet->total_traffic_load }}</dd>

                                    <dd class="col-sm-5 text-uppercase">Dry Operating Weight</dd>
                                    <dd class="col-sm-7 text-uppercase">{{ $flight->loadsheet->dry_operating_weight }}</dd>

                                    <dd class="col-sm-5 text-uppercase">Zero Fuel Weight Actual</dd>
                                    <dd class="col-sm-7 text-uppercase d-flex align-items-center">
                                        {{ $flight->loadsheet->zero_fuel_weight_actual }}
                                        <span class="ms-3">MAX {{ $flight->registration->aircraftType->max_zero_fuel_weight }}</span>
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
