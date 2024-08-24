@extends('layouts.app')

@section('content')
    <h1>{{ isset($hold) ? 'Edit Hold' : 'Create Hold' }}</h1>
    <form action="{{ isset($hold) ? route('holds.update', $hold->id) : route('holds.store', $registration->id) }}" method="POST">
        @csrf
        @if(isset($hold))
            @method('PUT')
        @endif
        <div class="mb-3">
            <label for="hold_no" class="form-label">Hold No</label>
            <input type="text" id="hold_no" name="hold_no" class="form-control" value="{{ $hold->hold_no ?? old('hold_no') }}" required>
        </div>
        <div class="mb-3">
            <label for="fwd" class="form-label">FWD Distance (m)</label>
            <input type="number" id="fwd" name="fwd" class="form-control" value="{{ $hold->fwd ?? old('fwd') }}" required>
        </div>
        <div class="mb-3">
            <label for="aft" class="form-label">AFT Distance (m)</label>
            <input type="number" id="aft" name="aft" class="form-control" value="{{ $hold->aft ?? old('aft') }}" required>
        </div>
        <div class="mb-3">
            <label for="restrictions" class="form-label">Restrictions</label>
            <input type="text" id="restrictions" name="restrictions" class="form-control" value="{{ $hold->restrictions ?? old('restrictions') }}">
        </div>
        <button type="submit" class="btn btn-primary">{{ isset($hold) ? 'Update' : 'Create' }}</button>
    </form>
@endsection
