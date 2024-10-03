@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        @isset($flight)
            <livewire:flight-tabs :flight="$flight" :tab="$activeTab" />
        @else
            <p class="mt-4 fw-medium">Select a flight from the sidebar to view details.</p>
        @endisset
    </div>
@endsection
