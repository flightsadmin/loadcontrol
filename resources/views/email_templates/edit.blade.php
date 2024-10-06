@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-12">
                @if ($errors->any())
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Whoops! Something went wrong.</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Edit Email Template</h4>
                        <a href="{{ route('email_templates.index') }}" class="btn btn-sm btn-danger float-end">Back</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('email_templates.update', $emailTemplate->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name">Template Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $emailTemplate->name }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="subject">Email Subject</label>
                                <input type="text" name="subject" class="form-control" value="{{ $emailTemplate->subject }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="body">Email Body</label>
                                <input id="body" type="hidden" name="body" value="{{ $emailTemplate->body }}" required>
                                <trix-editor input="body"></trix-editor>
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary float-end">Update Template</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
