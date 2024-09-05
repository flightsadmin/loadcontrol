@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <a href="{{ url('roles') }}" class="btn btn-sm btn-primary mx-1">Roles</a>
        <a href="{{ url('permissions') }}" class="btn btn-sm btn-info mx-1">Permissions</a>
        <a href="{{ url('users') }}" class="btn btn-sm btn-warning mx-1">Users</a>
    </div>

    <div class="container mt-2">
        <div class="row">
            <div class="col-md-12">

                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show">{{ session('status') }}</div>
                @endif

                <div class="card mt-3">
                    <div class="card-header">
                        <h4>Users
                            @can('create user')
                                <a href="{{ url('users/create') }}" class="btn btn-sm btn-primary float-end">Add User</a>
                            @endcan
                        </h4>
                    </div>
                    <div class="card-body">

                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if (!empty($user->getRoleNames()))
                                                @foreach ($user->getRoleNames() as $rolename)
                                                    <label class="badge bg-primary mx-1">{{ $rolename }}</label>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            @can('update user')
                                                <a href="{{ route('users.edit', $user->id) }}"
                                                    class="btn btn-link btn-sm bi-pencil-square text-info"></a>
                                            @endcan

                                            @can('delete user')
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link btn-sm bi-trash-fill text-danger"
                                                        onclick="return confirm('Are you sure you want to delete this user?')"></button>
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
