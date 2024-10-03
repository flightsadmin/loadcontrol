<div class="mt-2 position-relative">
    @role('super-admin')
        <div class="position-absolute top-0 end-0">
            <a href="{{ route('aircraft_types.index') }}" class="btn btn-sm btn-primary bi-gear-wide-connected">
                Settings
            </a>
            <a href="{{ route('users.index') }}" class="btn btn-sm btn-primary bi-person-gear">
                Admin
            </a>
        </div>
    @endrole
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link bi-airplane-engines-fill {{ $activeTab == 'flight' ? 'active' : '' }}"
                href="" wire:click.prevent="setActiveTab('flight')" role="tab">
                Flight Data
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link bi-people-fill {{ $activeTab == 'passengers' ? 'active' : '' }}"
                href="" wire:click.prevent="setActiveTab('passengers')" role="tab">
                Passengers
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link bi-luggage-fill {{ $activeTab == 'cargo' ? 'active' : '' }}"
                href="" wire:click.prevent="setActiveTab('cargo')" role="tab">
                Deadload
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link bi-fuel-pump-fill {{ $activeTab == 'fuel' ? 'active' : '' }}"
                href="" wire:click.prevent="setActiveTab('fuel')" role="tab">
                Fuel
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link bi-file-earmark-pdf-fill {{ $activeTab == 'documents' ? 'active' : '' }}"
                href="" wire:click.prevent="setActiveTab('documents')" role="tab">
                Documents
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link bi-chat-dots-fill {{ $activeTab == 'chat' ? 'active' : '' }}"
                href="" wire:click.prevent="setActiveTab('chat')" role="tab">
                Chat
            </a>
        </li>
    </ul>

    <div class="tab-content mt-3">
        <div class="tab-pane fade {{ $activeTab == 'flight' ? 'show active' : '' }}" role="tabpanel">
            @include('flight.partials.index', ['flight' => $flight])
        </div>
        <div class="tab-pane fade {{ $activeTab == 'passengers' ? 'show active' : '' }}" role="tabpanel">
            @include('flight.partials.passengers', ['flight' => $flight])
        </div>
        <div class="tab-pane fade {{ $activeTab == 'cargo' ? 'show active' : '' }}" role="tabpanel">
            @include('flight.partials.planning', ['flight' => $flight])
        </div>
        <div class="tab-pane fade {{ $activeTab == 'fuel' ? 'show active' : '' }}" role="tabpanel">
            @include('flight.partials.fuel', ['flight' => $flight])
        </div>
        <div class="tab-pane fade {{ $activeTab == 'documents' ? 'show active' : '' }}" role="tabpanel">
            @include('flight.partials.documents', ['flight' => $flight])
        </div>
        <div class="tab-pane fade {{ $activeTab == 'chat' ? 'show active' : '' }}" role="tabpanel">
            @livewire('chat', ['flight' => $flight])
        </div>
    </div>
</div>
