@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Import SQL File</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="sql_file">Select SQL File</label>
            <input type="file" name="sql_file" id="sql_file" class="form-control @error('sql_file') is-invalid @enderror" required>
            @error('sql_file')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary mt-3">Import</button>
    </form>
</div>
@endsection
