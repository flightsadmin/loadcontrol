<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <h5 class="fw-bold text-decoration-underline">Cabin Crew Seating Table</h5>
        <a href="#" class="mb-0 h5 {{ $isEditable ? 'bi-eye text-warning' : 'bi-pencil-square text-primary' }}"
            wire:click.prevent="toggleEdit"></a>
    </div>
    @empty(!$crewSeats)
        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>Number of Cabin Crew</th>
                        @foreach ($crewLocations as $key => $value)
                            <th> {{ $value['location'] }} </th>
                        @endforeach
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
                                @foreach ($crewLocations as $key => $value)
                                    <td>
                                        <input type="number" class="form-control form-control-sm"
                                            wire:model="crewSeats.{{ $index }}.{{ Str::snake(strtolower($value['location'])) }}">
                                    </td>
                                @endforeach
                            @else
                                <td>{{ $row['number'] }}</td>
                                @foreach ($crewLocations as $key => $value)
                                    <td>{{ $row[Str::snake(strtolower($value['location']))] ?? '' }}</td>
                                @endforeach
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
    @endempty

    @if ($isEditable)
        <div class="mt-2">
            <button wire:click.prevent="addSeat" class="btn btn-sm btn-secondary">+ Add Row</button>
            <button wire:click.prevent="save" class="btn btn-sm btn-info float-end">Save Changes</button>
        </div>
    @endif
</div>
