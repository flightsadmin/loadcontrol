@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-4">
        <a href="{{ url('users') }}" class="btn btn-sm btn-warning mx-1 bi-people-fill"> Users</a>
        <a href="{{ url('roles') }}" class="btn btn-sm btn-primary mx-1 bi-shield-lock-fill"> Roles</a>
        <a href="{{ url('permissions') }}" class="btn btn-sm btn-info mx-1 bi-database-fill-lock"> Permissions</a>
        <a href="{{ url('email_templates') }}" class="btn btn-sm btn-secondary mx-1 bi-envelope-plus-fill"> Email Templates</a>
    </div>
    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col-md-12">

                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show">{{ session('status') }}</div>
                @endif

                <div class="card mt-3">
                    <div class="card-header">
                        <h4>Email Templates
                            @can('create user')
                                <a href="{{ route('email_templates.create') }}" class="btn btn-sm btn-primary float-end">Create New Template</a>
                            @endcan
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table mt-3">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Subject</th>
                                    <th>Subject</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($templates as $template)
                                    <tr>
                                        <td>{{ $template->name }}</td>
                                        <td>{{ $template->subject }}</td>
                                        <td>{!! $template->body !!}</td>
                                        <td>
                                            <a href="{{ route('email_templates.edit', $template->id) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('email_templates.destroy', $template->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
