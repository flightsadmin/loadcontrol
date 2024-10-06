@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <livewire:envelope-manager :aircraftType="$aircraftType->id" />
    </div>
@endsection
