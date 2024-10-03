@extends('layouts.app')

@section('content')

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">

                @if ($errors->any())
                    <ul class="alert alert-warning alert-dismissible fade show">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h4>Create Email Template
                            <a href="{{ route('email_templates.index') }}" class="btn btn-sm btn-danger float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('email_templates.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name">Template Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="subject">Email Subject</label>
                                <input type="text" name="subject" class="form-control" required>
                            </div>

                            {{-- <div class="mb-3">
                                <label for="body">Email Body</label>
                                <textarea name="body" class="form-control" rows="10" required></textarea>
                            </div> --}}
                            <div class="mb-3">
                                <label for="body">Email Body</label>
                                <input id="body" type="hidden" name="body" required>
                                <trix-editor input="body"></trix-editor>
                            </div>

                            <button type="submit" class="btn btn-sm btn-primary float-end">Save Template</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
