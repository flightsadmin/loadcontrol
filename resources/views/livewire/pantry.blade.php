<div class="container mb-4">
    <ul class="list-group mb-4">
        @forelse ($pantries as $index => $pantry)
            <li class="list-group-item">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" class="form-control form-control-sm" wire:model="pantries.{{ $index }}.name"
                                placeholder="Enter pantry name">
                            @error('pantries.' . $index . '.name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <input type="number" class="form-control form-control-sm" wire:model="pantries.{{ $index }}.weight"
                                placeholder="Enter weight">
                            @error('pantries.' . $index . '.weight')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <input type="number" class="form-control form-control-sm" step="any"
                                wire:model="pantries.{{ $index }}.index"
                                placeholder="Enter index">
                            @error('pantries.' . $index . '.index')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-1">
                            <a href="#" class="btn btn-sm btn-link text-danger bi-trash3" wire:confirm="Are you sure"
                                wire:click.prevent="removePantry({{ $index }})"></a>
                        </div>
                    </div>
                </div>
            </li>
        @empty
            <p>No Pantry Codes available for this Aircraft Type.</p>
        @endforelse
        <div class="mt-2">
            <button wire:click.prevent="addPantry" class="btn btn-sm btn-secondary">+ Add a Pantry</button>
            <button wire:click.prevent="save" class="btn btn-sm btn-info float-end">Save Pantries</button>
        </div>
    </ul>
</div>
