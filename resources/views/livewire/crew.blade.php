<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <h5 class="fw-bold text-decoration-underline">Crew and Index Table</h5>
        <a href="#" class="mb-0 h5 {{ $isEditable ? 'bi-eye text-warning' : 'bi-pencil-square text-primary' }}"
            wire:click.prevent="toggleEdit"> </a>
    </div>
    <div class="table-responsive">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Location</th>
                    <th>Max Number</th>
                    <th>Arm</th>
                    <th>Index</th>
                    @if ($isEditable)
                        <th>Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="100%" class="text-center">
                        Deck Crew
                    </td>
                </tr>
                @forelse ($deck_crew as $index => $value)
                    <tr>
                        @if ($isEditable)
                            <td>
                                <input type="text" class="form-control form-control-sm"
                                    wire:model="deck_crew.{{ $index }}.location">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm"
                                    wire:model="deck_crew.{{ $index }}.max_number">
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm"
                                    wire:model="deck_crew.{{ $index }}.arm">
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm"
                                    wire:model="deck_crew.{{ $index }}.index">
                            </td>
                            @role('super-admin|admin')
                                <td>
                                    <a href="#" class="btn btn-sm btn-link text-danger bi-trash3"
                                        wire:click.prevent="removeCrew({{ $index }})"></a>
                                </td>
                            @endrole
                        @else
                            <td>{{ $value['location'] }}</td>
                            <td>{{ $value['max_number'] }}</td>
                            <td>{{ $value['arm'] }}</td>
                            <td>{{ $value['index'] }}</td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="100%" class="text-center">No Deck Crew for this flight yet</td>
                    </tr>
                @endforelse
            </tbody>
            <tbody>
                <tr>
                    <td colspan="100%" class="text-center">
                        Cabin Crew
                    </td>
                </tr>

                @forelse ($cabin_crew as $index => $value)
                    <tr>
                        @if ($isEditable)
                            <td>
                                <input type="text" class="form-control form-control-sm"
                                    wire:model="cabin_crew.{{ $index }}.location">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm"
                                    wire:model="cabin_crew.{{ $index }}.max_number">
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm"
                                    wire:model="cabin_crew.{{ $index }}.arm">
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm"
                                    wire:model="cabin_crew.{{ $index }}.index">
                            </td>
                            @role('super-admin|admin')
                                <td>
                                    <a href="#" class="btn btn-sm btn-link text-danger bi-trash3"
                                        wire:click.prevent="removeCrew({{ $index }})"></a>
                                </td>
                            @endrole
                        @else
                            <td>{{ $value['location'] }}</td>
                            <td>{{ $value['max_number'] }}</td>
                            <td>{{ $value['arm'] }}</td>
                            <td>{{ $value['index'] }}</td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="100%" class="text-center">No Cabin Crew for this aircraft type yet</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($isEditable)
        <div class="mt-2">
            <button wire:click.prevent="addCrew" class="btn btn-sm btn-secondary">+ Add a Cabin Crew</button>
            <button wire:click.prevent="save" class="btn btn-sm btn-info float-end">Save Changes</button>
        </div>
    @endif
</div>
