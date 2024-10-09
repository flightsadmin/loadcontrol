<!-- Create / Edit Airlines Modal -->
<div wire:ignore.self class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModalLabel">
                    Create New Airline
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="saveAirline">
                    <div class="row">
                        <h5 class="fw-bold">Airline Details</h5>
                        <div class="form-group col-md-6 mb-2">
                            <label for="name">Airline Name</label>
                            <input type="text" id="name" wire:model="name" class="form-control" />
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6 mb-2">
                            <label for="iata_code">IATA Code</label>
                            <input type="text" id="iata_code" wire:model="iata_code" class="form-control" maxlength="2" />
                            @error('iata_code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6 mb-2">
                            <label for="base">Base</label>
                            <input type="text" id="base" wire:model="base" class="form-control" />
                            @error('base')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6 mb-2">
                            <label for="base_iata_code">Base IATA Code</label>
                            <input type="text" id="base_iata_code" wire:model="base_iata_code" class="form-control" maxlength="3" />
                            @error('base_iata_code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <h5 class="fw-bold">Standard Crew Weights</h5>
                        <div class="form-group col-md-6 mb-2">
                            <label for="deck_crew_weight">Deck Crew</label>
                            <input type="number" id="deck_crew_weight" wire:model="settings.crew.deck_crew_weight"
                                class="form-control" />
                            @error('settings.crew.deck_crew_weight')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6 mb-2">
                            <label for="cabin_crew_weight">Cabin Crew</label>
                            <input type="number" id="cabin_crew_weight" wire:model="settings.crew.cabin_crew_weight"
                                class="form-control" />
                            @error('settings.crew.cabin_crew_weight')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <h5 class="fw-bold">Standard Passenger Weights</h5>
                    <div class="row mb-3 d-flex justify-content-between align-items-center">
                        <div class="col-md-2">
                            <label for="male">Male</label>
                            <input type="number" id="male" wire:model="settings.passenger_weights.male"
                                class="form-control" />
                            @error('settings.passenger_weights.male')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-2">
                            <label for="female">Female</label>
                            <input type="number" id="female" wire:model="settings.passenger_weights.female"
                                class="form-control" />
                            @error('settings.passenger_weights.female')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-2">
                            <label for="child">Child</label>
                            <input type="number" id="child" wire:model="settings.passenger_weights.child"
                                class="form-control" />
                            @error('settings.passenger_weights.child')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-2">
                            <label for="infant">Infant</label>
                            <input type="number" id="infant" wire:model="settings.passenger_weights.infant"
                                class="form-control" />
                            @error('settings.passenger_weights.infant')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-2">
                            <label for="default">Default</label>
                            <input type="number" id="default" wire:model="settings.passenger_weights.default"
                                class="form-control" />
                            @error('settings.passenger_weights.default')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex align-items-center justify-content-between">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                <button wire:click.prevent="saveAirline" type="button" class="btn btn-sm btn-primary bi-check2-circle"> Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Create / Edit Routes Modal -->
<div wire:ignore.self class="modal fade" id="routeModal" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModalLabel">
                    Airline Routes
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <form>
                        <div class="row">
                            <input type="hidden" wire:model="airline_id">
                            <div class="col-md-6 mb-3">
                                <label for="origin">Origin:</label>
                                <input type="text" maxlength="4" id="origin" class="form-control" wire:model.blur="origin">
                                @error('origin')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="destination">Destination:</label>
                                <input type="text" id="destination" maxlength="34" class="form-control"
                                    wire:model.blur="destination">
                                @error('destination')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="flight_time">Flight Time:</label>
                                <input type="text" id="flight_time" maxlength="4" class="form-control form-control-sm"
                                    wire:model.blur="flight_time" placeholder="0000">
                                @error('flight_time')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="emails">Emails:</label>
                                <div class="d-flex gap-4">
                                    <input type="text" id="emails" class="form-control form-control-sm" wire:model.blur="email"
                                        placeholder="example test@test.com">
                                    <a href="" wire:click.prevent="addEmail('{{ $email }}')"
                                        class="text-danger h5 bi-envelope-plus-fill"></a>
                                </div>
                                <ol class="mt-2">
                                    @foreach ($emails as $email)
                                        <li>{{ $email }} <a href=""
                                                wire:click.prevent="removeEmail('{{ $email }}')"
                                                class="bi-trash"></a></li>
                                    @endforeach
                                </ol>
                                @error('email')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer d-flex align-items-center justify-content-between">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-sm btn-primary bi-check2-circle" wire:click.prevent="saveRoute"> Save</span>
                </button>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script type="module">
        const genModal = new bootstrap.Modal('#dataModal');
        const routeModal = new bootstrap.Modal('#routeModal');
        window.addEventListener('closeModal', () => {
            genModal.hide();
            routeModal.hide();
        });
    </script>
@endpush
