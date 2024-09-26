@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        @isset($flight)
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
                           id="flight-tab"
                           wire:navigate
                           href="{{ route('flights.show', ['flight' => $flight->id, 'tab' => 'flight']) }}" 
                           role="tab" aria-controls="flight" aria-selected="{{ $activeTab == 'flight' ? 'true' : 'false' }}"> 
                           Flight Data
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link bi-people-fill {{ $activeTab == 'passengers' ? 'active' : '' }}" 
                           id="passengers-tab"
                           wire:navigate 
                           href="{{ route('flights.show', ['flight' => $flight->id, 'tab' => 'passengers']) }}" 
                           role="tab" aria-controls="passengers" aria-selected="{{ $activeTab == 'passengers' ? 'true' : 'false' }}"> 
                           Passengers
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link bi-luggage-fill {{ $activeTab == 'cargo' ? 'active' : '' }}" 
                           id="cargo-tab"
                           wire:navigate 
                           href="{{ route('flights.show', ['flight' => $flight->id, 'tab' => 'cargo']) }}" 
                           role="tab" aria-controls="cargo" aria-selected="{{ $activeTab == 'cargo' ? 'true' : 'false' }}"> 
                           Deadload
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link bi-fuel-pump-fill {{ $activeTab == 'fuel' ? 'active' : '' }}" 
                           id="fuel-tab"
                           wire:navigate 
                           href="{{ route('flights.show', ['flight' => $flight->id, 'tab' => 'fuel']) }}" 
                           role="tab" aria-controls="fuel" aria-selected="{{ $activeTab == 'fuel' ? 'true' : 'false' }}"> 
                           Fuel
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link bi-file-earmark-pdf-fill {{ $activeTab == 'documents' ? 'active' : '' }}" 
                           id="documents-tab"
                           wire:navigate 
                           href="{{ route('flights.show', ['flight' => $flight->id, 'tab' => 'documents']) }}" 
                           role="tab" aria-controls="documents" aria-selected="{{ $activeTab == 'documents' ? 'true' : 'false' }}"> 
                           Documents
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link bi-chat-dots-fill {{ $activeTab == 'chat' ? 'active' : '' }}" 
                           id="chat-tab"
                           wire:navigate 
                           href="{{ route('flights.show', ['flight' => $flight->id, 'tab' => 'chat']) }}" 
                           role="tab" aria-controls="chat" aria-selected="{{ $activeTab == 'chat' ? 'true' : 'false' }}"> 
                           Chat
                        </a>
                    </li>
                </ul>

                <div class="tab-content mt-3" id="myTabContent">
                    <div class="tab-pane fade {{ $activeTab == 'flight' ? 'show active' : '' }}" id="flight" role="tabpanel" aria-labelledby="flight-tab">
                        @include('flight.partials.index', ['flight' => $flight])
                    </div>
                    <div class="tab-pane fade {{ $activeTab == 'passengers' ? 'show active' : '' }}" id="passengers" role="tabpanel" aria-labelledby="passengers-tab">
                        @include('flight.partials.passengers', ['flight' => $flight])
                    </div>
                    <div class="tab-pane fade {{ $activeTab == 'cargo' ? 'show active' : '' }}" id="cargo" role="tabpanel" aria-labelledby="cargo-tab">
                        @include('flight.partials.planning', ['flight' => $flight])
                    </div>
                    <div class="tab-pane fade {{ $activeTab == 'fuel' ? 'show active' : '' }}" id="fuel" role="tabpanel" aria-labelledby="fuel-tab">
                        @include('flight.partials.fuel', ['flight' => $flight])
                    </div>
                    <div class="tab-pane fade {{ $activeTab == 'documents' ? 'show active' : '' }}" id="documents" role="tabpanel" aria-labelledby="documents-tab">
                        @include('flight.partials.documents', ['flight' => $flight])
                    </div>
                    <div class="tab-pane fade {{ $activeTab == 'chat' ? 'show active' : '' }}" id="chat" role="tabpanel" aria-labelledby="chat-tab">
                        @livewire('chat', ['flight' => $flight])
                    </div>
                </div>
            </div>
        @else
            <p class="mt-4 fw-medium">Select a flight from the sidebar to view details.</p>
        @endisset
    </div>
@endsection
