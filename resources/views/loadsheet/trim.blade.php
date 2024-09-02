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
                                            <td>{{ auth()->user()->name }}</td>
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
                                    <dd class="col-sm-4">Passenger / Cabin Bag</dd>
                                    <dd class="col-sm-8">
                                        @forelse (json_decode($flight->loadsheet->passenger_distribution, true) as $type => $count)
                                            {{ $count . '/' }}
                                        @empty
                                            Nil
                                        @endforelse
                                        <span class="ms-3">TTL</span>
                                    </dd>

                                    <dd class="col-sm-4">Compartment Loads</dd>
                                    <dd class="col-sm-8">
                                        @forelse (json_decode($flight->loadsheet->compartment_loads, true) as $compartment)
                                            {{ ucfirst($compartment['hold_no']) }}/{{ $compartment['weight'] }}.
                                        @empty
                                            Nil
                                        @endforelse
                                    </dd>

                                    <dd class="col-sm-4">Total Traffic Load</dd>
                                    <dd class="col-sm-8">{{ $flight->loadsheet->total_traffic_load }}</dd>

                                    <dd class="col-sm-4">Dry Operating Weight</dd>
                                    <dd class="col-sm-8">{{ $flight->loadsheet->dry_operating_weight }}</dd>

                                    <dd class="col-sm-4">Zero Fuel Weight Actual</dd>
                                    <dd class="col-sm-8 d-flex align-items-center">
                                        {{ $flight->loadsheet->zero_fuel_weight_actual }}
                                        <span class="ms-3 text-muted">MAX
                                            {{ $flight->registration->aircraftType->max_zero_fuel_weight }}</span>
                                        <span class="ms-4 text-muted">ADJ</span>
                                    </dd>

                                    <dd class="col-sm-4">Takeoff Fuel</dd>
                                    <dd class="col-sm-8">{{ $flight->loadsheet->take_off_fuel }}</dd>

                                    <dd class="col-sm-4">Takeoff Weight Actual</dd>
                                    <dd class="col-sm-8 d-flex align-items-center">
                                        {{ $flight->loadsheet->take_off_weight_actual }}
                                        <span class="ms-3 text-muted">MAX {{ $flight->registration->aircraftType->max_takeoff_weight }}</span>
                                        <span class="ms-4 text-muted">ADJ</span>
                                    </dd>

                                    <dd class="col-sm-4">Trip Fuel</dd>
                                    <dd class="col-sm-8">{{ $flight->loadsheet->trip_fuel }}</dd>

                                    <dd class="col-sm-4">Landing Weight Actual</dd>
                                    <dd class="col-sm-8 d-flex align-items-center">
                                        {{ $flight->loadsheet->landing_weight_actual }}
                                        <span class="ms-3 text-muted">MAX {{ $flight->registration->aircraftType->max_landing_weight }}</span>
                                        <span class="ms-4 text-muted">ADJ</span>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <canvas id="trimSheetChart"></canvas>
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
        const ldwEnvelopeData = @json($ldwEnvelope);
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
                        borderColor: 'green',
                        showLine: true,
                        pointRadius: 0,
                        fill: false,
                    },
                    {
                        label: 'LDW Envelope',
                        data: ldwEnvelopeData,
                        borderColor: 'blue',
                        showLine: true,
                        pointRadius: 0,
                        fill: false,
                    },
                    {
                        label: 'ZFW',
                        data: [{
                            x: 52,
                            y: {{ $flight->loadsheet->zero_fuel_weight_actual / 1000 ?? 0 }}
                        }],
                        backgroundColor: 'red',
                        pointRadius: 5
                    },
                    {
                        label: 'TOW',
                        data: [{
                            x: 54,
                            y: {{ $flight->loadsheet->take_off_weight_actual / 1000 ?? 0 }}
                        }],
                        backgroundColor: 'green',
                        pointRadius: 5
                    },
                    {
                        label: 'Landing Weight',
                        data: [{
                            x: 53,
                            y: {{ $flight->loadsheet->landing_weight_actual / 1000 ?? 0 }}
                        }],
                        backgroundColor: 'blue',
                        pointRadius: 5
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
                        min: 37,
                        max: 75
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
                                label += '(' + context.raw.x + '% MAC, ' + (context.raw.y * 1000).toLocaleString() + ' kg)';
                                return label;
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection
