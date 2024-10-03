@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <a href="{{ url('users') }}" class="btn btn-sm btn-warning mx-1 bi-people-fill"> Users</a>
        <a href="{{ url('roles') }}" class="btn btn-sm btn-primary mx-1 bi-shield-lock-fill"> Roles</a>
        <a href="{{ url('permissions') }}" class="btn btn-sm btn-info mx-1 bi-database-fill-lock"> Permissions</a>
        <a href="{{ url('email_templates') }}" class="btn btn-sm btn-secondary mx-1 bi-envelope-plus-fill"> Email Templates</a>
    </div>

    <div class="container mt-2">
        <div class="row">
            <div class="col-md-12">

                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show">{{ session('status') }}</div>
                @endif

                <div class="card mt-3">
                    <div class="card-header">
                        <h4>
                            Roles
                            @can('create role')
                                <a href="{{ url('roles/create') }}" class="btn btn-sm btn-primary float-end">Add Role</a>
                            @endcan
                        </h4>
                    </div>
                    <div class="card-body">

                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th width="40%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $role->id }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            <a href="{{ url('roles/' . $role->id . '/give-permissions') }}" class="btn btn-sm btn-warning">
                                                Add / Edit Role Permission
                                            </a>

                                            @can('update role')
                                                <a href="{{ route('roles.edit', $role->id) }}"
                                                    class="btn btn-info btn-sm bi-pencil-square"></a>
                                            @endcan

                                            @can('delete role')
                                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm bi-trash-fill"
                                                        onclick="return confirm('Are you sure you want to delete this role?')"></button>
                                                </form>
                                            @endcan
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
