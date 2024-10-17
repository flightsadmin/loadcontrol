<div class="card my-4">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold text-decoration-underline">Envelopes</h5>
            @if ($isEditable)
                <div class="d-flex d-flex justify-content-between align-items-center">
                    <input type="text" wire:model.defer="newEnvelopeType" placeholder="New Envelope Type"
                        class="form-control form-control-sm me-4" />
                    <a href="" wire:click.prevent="createType" class="m-0 h5 bi-database-fill-add text-success"></a>
                </div>
            @endif
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            @foreach ($envelopes as $type => $envelopeGroup)
                <div class="col-md-4 mb-3">
                    <div class="table-responsive">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold text-decoration-underline mt-3">{{ $type }}</h6>
                            <a href="#"
                                class="mb-0 h6 {{ isset($isEditable[$type]) && $isEditable[$type] ? 'bi-eye text-warning' : 'bi-pencil-square text-primary' }}"
                                wire:click.prevent="toggleEdit('{{ $type }}')"></a>
                        </div>
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Index</th>
                                    <th>Weight</th>
                                    @if (isset($isEditable[$type]) && $isEditable[$type])
                                        <th>Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($envelopeGroup as $index => $envelope)
                                    <tr>
                                        @if (isset($isEditable[$type]) && $isEditable[$type])
                                            <td>
                                                <input type="number" class="form-control form-control-sm"
                                                    wire:model.defer="envelopes.{{ $type }}.{{ $index }}.index">
                                                @error("envelopes.{$type}.{$index}.index")
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm"
                                                    wire:model.defer="envelopes.{{ $type }}.{{ $index }}.weight">
                                                @error("envelopes.{$type}.{$index}.weight")
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-link text-danger bi-trash3"
                                                    wire:click.prevent="removeEnvelope('{{ $type }}', {{ $index }})"></a>
                                            </td>
                                        @else
                                            <td>{{ $envelope['index'] }}</td>
                                            <td>{{ $envelope['weight'] }}</td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if (isset($isEditable[$type]) && $isEditable[$type])
                            <button wire:click.prevent="addEnvelope('{{ $type }}')" class="btn btn-sm btn-secondary mt-2">+ Add
                                Envelope</button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        @if ($isEditable)
            <div class="mt-2">
                <button wire:click.prevent="save" class="btn btn-sm btn-info float-end">Save Changes</button>
            </div>
        @endif
    </div>
</div>
