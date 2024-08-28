@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        @isset($flight)
            <div class="mt-2">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link bi-airplane-engines-fill" id="flight-tab" data-bs-toggle="tab" href="#flight" role="tab"
                            aria-controls="flight" data-tab="flight" aria-selected="true"> Flight Data</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link bi-people-fill" id="passengers-tab" data-bs-toggle="tab" href="#passengers" role="tab"
                            aria-controls="passengers" data-tab="passengers" aria-selected="false"> Passengers</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link bi-luggage-fill" id="cargo-tab" data-bs-toggle="tab" href="#cargo" role="tab"
                            aria-controls="cargo" data-tab="cargo" aria-selected="false"> Deadload</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link bi-fuel-pump-fill" id="fuel-tab" data-bs-toggle="tab" href="#fuel" role="tab"
                            aria-controls="fuel" data-tab="fuel" aria-selected="false"> Fuel</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link bi-file-earmark-pdf-fill" id="documents-tab" data-bs-toggle="tab" href="#documents" role="tab"
                            aria-controls="documents" data-tab="documents" aria-selected="false"> Documents</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link bi-chat-dots-fill" id="chat-tab" data-bs-toggle="tab" href="#chat" role="tab"
                            aria-controls="chat" data-tab="chat" aria-selected="false"> Chat</a>
                    </li>
                </ul>

                <div class="tab-content mt-3" id="myTabContent">
                    <div class="tab-pane fade" id="flight" role="tabpanel" aria-labelledby="flight-tab">
                        @include('flight.partials.index', ['flight' => $flight])
                    </div>
                    <div class="tab-pane fade" id="passengers" role="tabpanel" aria-labelledby="passengers-tab">
                        @include('flight.partials.passengers', ['flight' => $flight])
                    </div>
                    <div class="tab-pane fade" id="cargo" role="tabpanel" aria-labelledby="cargo-tab">
                        @include('flight.partials.planning', ['flight' => $flight])
                    </div>
                    <div class="tab-pane fade" id="fuel" role="tabpanel" aria-labelledby="fuel-tab">
                        @include('flight.partials.fuel', ['flight' => $flight])
                    </div>
                    <div class="tab-pane fade" id="documents" role="tabpanel" aria-labelledby="documents-tab">
                        @include('flight.partials.documents', ['flight' => $flight])
                    </div>
                    <div class="tab-pane fade" id="chat" role="tabpanel" aria-labelledby="chat-tab">
                        @livewire('chat', ['flight' => $flight])
                    </div>
                </div>
            </div>
        @else
            <p class="mt-4 fw-medium">Select a flight from the sidebar to view details.</p>
        @endisset
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('#myTab .nav-link');
            const urlParams = new URLSearchParams(window.location.search);
            const activeTab = urlParams.get('tab') || 'flight';
            const setActiveTab = (tabId) => {
                document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
                document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('show', 'active'));
                document.querySelector(`#${tabId}-tab`).classList.add('active');
                document.querySelector(`#${tabId}`).classList.add('show', 'active');
            };
            setActiveTab(activeTab);

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const tabId = this.getAttribute('data-tab');
                    const newUrl = new URL(window.location.href);
                    newUrl.searchParams.set('tab', tabId);
                    window.history.pushState({}, '', newUrl);
                    setActiveTab(tabId);
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const savedDate = localStorage.getItem('selectedDate');
            if (savedDate) {
                document.getElementById('date-picker').value = savedDate;
            }

            document.getElementById('date-picker').addEventListener('change', function() {
                localStorage.setItem('selectedDate', this.value);
            });
        });
    </script>
@endsection
