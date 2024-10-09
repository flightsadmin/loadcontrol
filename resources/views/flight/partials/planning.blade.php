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
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <ul class="list-group list-group-sm">
                        @forelse($flight->cargos->where('hold_id', null) as $cargo)
                            <li class="list-group-item cargo-item" draggable="true" data-cargo-id="{{ $cargo->id }}">
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
                            <div class="hold" data-hold-id="{{ $hold->id }}"
                                style="top: 0; left: {{ $hold->fwd }}%; width: {{ $hold->aft - $hold->fwd }}%; height: 100%; background-color: grey; border: 10px solid #6c757d; position: absolute;">
                                <span class="text-white">{{ $hold->hold_no }}
                                    <small>(Max {{ $hold->max }})</small>
                                </span>
                                <ul class="list-group list-group-sm list-group-item-dark">
                                    @forelse ($flight->cargos->where('hold_id', $hold->id) as $cargo)
                                        <li class="list-group-item cargo-item d-flex justify-content-between align-items-start"
                                            draggable="true" data-cargo-id="{{ $cargo->id }}">
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
        z-index: 10;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function initializeDragAndDrop() {
            const cargoItems = document.querySelectorAll('.cargo-item');
            const holds = document.querySelectorAll('.hold');
            const container = document.querySelector('.list-group');

            cargoItems.forEach(item => {
                item.setAttribute('draggable', true);

                item.addEventListener('dragstart', function(e) {
                    e.dataTransfer.setData('text/plain', e.target.dataset.cargoId);
                    item.classList.add('dragging');
                });

                item.addEventListener('dragend', function() {
                    item.classList.remove('dragging');
                });
            });

            holds.forEach(hold => {
                hold.addEventListener('dragover', function(e) {
                    e.preventDefault();
                });

                hold.addEventListener('drop', function(e) {
                    e.preventDefault();
                    const cargoId = e.dataTransfer.getData('text/plain');
                    const holdId = hold.dataset.holdId;
                    const cargoItem = document.querySelector(`[data-cargo-id='${cargoId}']`);
                    hold.querySelector('.list-group').appendChild(cargoItem);
                    saveCargoHold(cargoId, holdId);
                });
            });

            container.addEventListener('dragover', function(e) {
                e.preventDefault();
            });

            container.addEventListener('drop', function(e) {
                e.preventDefault();
                const cargoId = e.dataTransfer.getData('text/plain');
                const cargoItem = document.querySelector(`[data-cargo-id='${cargoId}']`);
                container.appendChild(cargoItem);
                saveCargoHold(cargoId, null);
            });
        }

        function saveCargoHold(cargoId, holdId) {
            fetch(`/cargos/${cargoId}/update-hold`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        hold_id: holdId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Cargo hold updated successfully');
                        reloadCargoView();
                    } else {
                        console.error('Failed to update cargo hold');
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function reloadCargoView() {
            fetch(window.location.href)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newContent = doc.querySelector('#cargo-view-container').innerHTML;
                    document.querySelector('#cargo-view-container').innerHTML = newContent;
                    initializeDragAndDrop();
                })
                .catch(error => console.error('Error:', error));
        }
        initializeDragAndDrop();
    });
</script>
