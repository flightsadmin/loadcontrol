<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <h5 class="fw-bold text-decoration-underline">Pantry Codes</h5>
        <a href="#" class="mb-0 h5 {{ $isEditable ? 'bi-eye text-warning' : 'bi-pencil-square text-primary' }}"
            wire:click.prevent="toggleEdit"> </a>
    </div>

    <div class="table-responsive">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Weight</th>
                    <th>Index</th>
                    @if ($isEditable)
                        <th>Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($pantries as $index => $pantry)
                    <tr>
                        @if ($isEditable)
                            <td>
                                <input type="text" class="form-control form-control-sm"
                                    wire:model="pantries.{{ $index }}.name"
                                    placeholder="Enter pantry name">
                                @error('pantries.' . $index . '.name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm"
                                    wire:model="pantries.{{ $index }}.weight"
                                    placeholder="Enter weight">
                                @error('pantries.' . $index . '.weight')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm" step="any"
                                    wire:model="pantries.{{ $index }}.index"
                                    placeholder="Enter index">
                                @error('pantries.' . $index . '.index')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-link text-danger bi-trash3"
                                    wire:click.prevent="removePantry({{ $index }})"></a>
                            </td>
                        @else
                            <td>{{ $pantry['name'] }}</td>
                            <td>{{ $pantry['weight'] }}</td>
                            <td>{{ $pantry['index'] }}</td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No Pantry Codes available for this Aircraft Type.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if ($isEditable)
        <div class="mt-2">
            <button wire:click.prevent="addPantry" class="btn btn-sm btn-secondary">+ Add a Pantry</button>
            <button wire:click.prevent="save" class="btn btn-sm btn-info float-end">Save Changes</button>
        </div>
    @endif
</div>
