<div>
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold text-decoration-underline">Cabin Crew Seating Table</h5>
        <button class="btn btn-sm {{ $isEditable ? 'btn-warning' : 'btn-primary' }}"
            wire:click="toggleEdit">
            {{ $isEditable ? 'View' : 'Edit' }}
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>Number of Cabin Crew</th>
                    <th>FWD of FWD Door</th>
                    <th>FWD of Aft Door RH</th>
                    <th>FWD of Aft Door LH</th>
                    <th>Aft of Aft Door</th>
                    @if ($isEditable)
                        <th>Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($crewSeats as $index => $row)
                    <tr>
                        @if ($isEditable)
                            <td>
                                <input type="number" class="form-control form-control-sm"
                                    wire:model="crewSeats.{{ $index }}.number">
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm"
                                    wire:model="crewSeats.{{ $index }}.fwd_of_fwd_door">
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm"
                                    wire:model="crewSeats.{{ $index }}.fwd_of_aft_door_rh">
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm"
                                    wire:model="crewSeats.{{ $index }}.fwd_of_aft_door_lh">
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm"
                                    wire:model="crewSeats.{{ $index }}.aft_of_aft_door">
                            </td>
                        @else
                            <td>{{ $row['number'] }}</td>
                            <td>{{ $row['fwd_of_fwd_door'] }}</td>
                            <td>{{ $row['fwd_of_aft_door_rh'] }}</td>
                            <td>{{ $row['fwd_of_aft_door_lh'] }}</td>
                            <td>{{ $row['aft_of_aft_door'] }}</td>
                        @endif
                        @if ($isEditable)
                            <td>
                                <button class="btn btn-sm btn-link text-danger bi-trash"
                                    wire:click.prevent="removeSeat({{ $index }})"> </button>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if ($isEditable)
        <div class="mt-2">
            <button wire:click.prevent="addSeat" class="btn btn-sm btn-secondary">+ Add Row</button>
            <button wire:click.prevent="save" class="btn btn-sm btn-info float-end">Save Changes</button>
        </div>
    @endif
</div>
