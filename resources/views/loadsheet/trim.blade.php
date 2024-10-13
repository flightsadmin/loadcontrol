@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card my-3">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Load and Trim Sheet</h4>
                    <form action="{{ route('loadsheets.finalize', ['flight' => $flight->id]) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-warning bi-envelope-paper"> Finalize Loadsheet</button>
                    </form>
                    <a href="{{ route('flights.show', ['flight' => $flight->id, 'tab' => 'cargo']) }}"
                        class="btn btn-secondary btn-sm bi-backspace float-end mt-0"> Back</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        @include('loadsheet.loadsheet-data')
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <canvas id="trimSheetChart" height="220"></canvas>
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
                            x: {{ json_decode($flight->loadsheet->payload_distribution, true)['lizfw'] }},
                            y: {{ json_decode($flight->loadsheet->payload_distribution, true)['zero_fuel_weight_actual'] / 1000 ?? 0 }}
                        }],
                        backgroundColor: 'red',
                        pointRadius: 4
                    },
                    {
                        label: 'TOW',
                        data: [{
                            x: {{ json_decode($flight->loadsheet->payload_distribution, true)['litow'] }},
                            y: {{ json_decode($flight->loadsheet->payload_distribution, true)['take_off_weight_actual'] / 1000 ?? 0 }}
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
