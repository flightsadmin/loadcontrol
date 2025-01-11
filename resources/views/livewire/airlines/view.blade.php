@section('title', __('Airlines'))
<div class="my-4 row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h3 class="card-title">Airlines</h3>
                    <div>
                        <input wire:model.live.debounce.500ms="keyWord" type="text" class="form-control form-control-sm" name="search"
                            id="search" placeholder="Search Airline">
                    </div>
                    <div class="btn btn-sm btn-info bi-plus-lg" data-bs-toggle="modal" data-bs-target="#dataModal">
                        Add Airline
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('livewire.airlines.modals')
                <div class="row">
                    @forelse($airlines as $row)
                        <div class="col-md-4 border d-flex justify-content-between">
                            <div class="col-md-8 mt-2">
                                <b><i class="bi-building-check text-success"></i> {{ $row->name }} - {{ $row->iata_code }}</b>
                                <div> <i class="bi-house-gear text-info"> </i> {{ $row->base }}</div>
                                <b>Routes</b>
                                <ol>
                                    @forelse ($row->routes as $route)
                                        <li wire:key="{{ $row->id }}">
                                            <div class="d-flex justify-content-between">
                                                {{ $route->origin }} - {{ $route->destination }} ({{ $route->flight_time }})
                                                <a href="" data-bs-toggle="modal" data-bs-target="#routeModal"
                                                    wire:click.prevent="editRoute({{ $route->id }})"
                                                    class="text-info bi-pencil-square"></a>
                                            </div>
                                            @forelse ($route->emails as $email)
                                                <ul class="d-flex justify-content-between">
                                                    <small class="me-4">{{ $email->email }}</small>
                                                    <a href="" wire:click.prevent="deleteRoute({{ $email->id }})"
                                                        class="text-danger bi-trash3-fill"
                                                        onclick="confirm('Confirm Delete {{ $email->email }} for {{ $row->name }}? \nDeleted Emails cannot be recovered!')||event.stopImmediatePropagation()"></a>
                                                </ul>
                                            @empty
                                                <p>NIL</p>
                                            @endforelse
                                        </li>
                                    @empty
                                        <p>No Routes Yet</p>
                                    @endforelse
                                </ol>
                            </div>
                            <div class="col-md-4 mt-2">
                                <div class="dropdown float-end">
                                    <a class="btn custom-btn-sm text-white btn-secondary dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="" data-bs-toggle="modal" data-bs-target="#dataModal"
                                                class="dropdown-item bi-pencil-square" wire:click.prevent="edit({{ $row->id }})"> Edit
                                            </a></li>
                                        <li><a href="" data-bs-toggle="modal" data-bs-target="#routeModal"
                                                class="dropdown-item bi-envelope-at-fill" wire:click.prevent="edit({{ $row->id }})">
                                                Create Address</a></li>
                                        <li><a href="" class="dropdown-item bi-trash3"
                                                onclick="confirm('Confirm Delete Airline id {{ $row->id }}? \nDeleted Airline cannot be recovered!')||event.stopImmediatePropagation()"
                                                wire:click.prevent="destroy({{ $row->id }})"> Delete </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-md-12">
                            <p class="text-center">No Airlines Created Yet</p>
                        </div>
                    @endforelse
                </div>
                <div class="float-end mt-2 mb-0">{{ $airlines->links() }}</div>
            </div>
        </div>
    </div>
</div>
