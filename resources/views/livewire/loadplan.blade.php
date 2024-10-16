<div>
    <div class="container-fluid" id="cargo-view-container">
        <div class="card mt-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5>Cargo for Flight: {{ $flight->flight_number }}</h5>
                    <form action="{{ route('flights.loadsheets.store', $flight->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-primary bi-file-earmark-pdf-fill"> Preview Loadsheet</button>
                    </form>
                    <a href="{{ route('flights.cargos.create', $flight->id) }}"
                        class="btn btn-primary btn-sm bi-plus-circle-dotted float-end mt-0"> Add Deadload</a>
                </div>
            </div>
            <div class="card-body" x-data="cargoDragAndDrop()">
                <div class="row">
                    <div class="col-md-3">
                        <ul class="list-group list-group-sm"
                            @dragover.prevent
                            @drop="dropCargo(null)">
                            @forelse($flight->cargos->where('hold_id', null) as $cargo)
                                <li class="list-group-item cargo-item"
                                    :class="{ 'dragging': isDragging && draggingCargoId == {{ $cargo->id }} }"
                                    draggable="true"
                                    @dragstart="startDrag({{ $cargo->id }})"
                                    @dragend="endDrag()">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            {{ ucfirst($cargo->type) }}, {{ $cargo->pieces }}pcs / {{ $cargo->weight }}kgs
                                        </div>
                                        <div class="d-flex">
                                            <a href="{{ route('cargos.edit', $cargo->id) }}" class="me-2 bi-pencil-square"></a>
                                            <form action="{{ route('cargos.destroy', $cargo->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link p-0 bi-trash-fill"></button>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="list-group-item">No Unplanned cargo.</li>
                            @endforelse
                        </ul>
                    </div>

                    <div class="col-md-9">
                        <div class="hold-figure">
                            @foreach ($flight->registration->aircraftType->holds as $hold)
                                @php
                                    $totalWeightInHold = $flight->cargos->where('hold_id', $hold->id)->sum('weight');
                                    $weightDifference = max(0, $totalWeightInHold - $hold->max);
                                @endphp
                                <div class="hold"
                                    data-hold-id="{{ $hold->id }}"
                                    style="top: 0; left: {{ $hold->fwd }}%; width: {{ $hold->aft - $hold->fwd }}%; height: 100%; background-color: grey; border: 10px solid #6c757d; position: absolute;"
                                    @dragover.prevent
                                    @drop="dropCargo({{ $hold->id }})">
                                    <span class="text-white">{{ $hold->hold_no }}
                                        <small>(Max {{ $hold->max }})</small>
                                        @if ($totalWeightInHold > $hold->max)
                                            <small class="bi-exclamation-circle-fill text-danger"
                                                title="Hold Max Exceeded by {{ $weightDifference }} kg"></small>
                                        @endif
                                    </span>
                                    <ul class="list-group list-group-sm list-group-item-dark">
                                        @forelse ($flight->cargos->where('hold_id', $hold->id) as $cargo)
                                            <li class="list-group-item cargo-item d-flex justify-content-between align-items-start"
                                                draggable="true"
                                                :class="{ 'dragging': isDragging && draggingCargoId == {{ $cargo->id }} }"
                                                @dragstart="startDrag({{ $cargo->id }})"
                                                @dragend="endDrag()">
                                                <span>{{ $cargo->weight }}kg</span>
                                                <span class="badge text-bg-primary rounded-pill">{{ $cargo->type }}</span>
                                            </li>
                                        @empty
                                            <span>NIL</span>
                                        @endforelse
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .hold-figure {
            position: relative;
            width: 100%;
            height: 200px;
            border: 1px solid #ddd;
            border-radius: 15px;
            background-color: #f8f9fa;
            margin-bottom: 20px;
            overflow: auto;
        }

        .hold {
            position: absolute;
            box-sizing: border-box;
            text-align: center;
        }

        .cargo-item {
            cursor: move;
        }

        .dragging {
            opacity: 0.5;
        }
    </style>

    <script>
        function cargoDragAndDrop() {
            return {
                isDragging: false,
                draggingCargoId: null,

                startDrag(cargoId) {
                    this.isDragging = true;
                    this.draggingCargoId = cargoId;
                },

                endDrag() {
                    this.isDragging = false;
                    this.draggingCargoId = null;
                },

                dropCargo(holdId) {
                    if (this.draggingCargoId !== null) {
                        @this.call('updateCargoHold', this.draggingCargoId, holdId);
                    }
                    this.endDrag();
                }
            };
        }
    </script>
</div>
