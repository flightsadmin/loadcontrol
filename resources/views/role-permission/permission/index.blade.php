@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <a href="{{ url('roles') }}" class="btn btn-sm btn-primary mx-1 bi-shield-lock-fill"> Roles</a>
        <a href="{{ url('permissions') }}" class="btn btn-sm btn-info mx-1 bi-database-fill-lock"> Permissions</a>
        <a href="{{ url('users') }}" class="btn btn-sm btn-warning mx-1 bi-people-fill"> Users</a>
    </div>

    <div class="container mt-2">
        <div class="row">
            <div class="col-md-12">

                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show">{{ session('status') }}</div>
                @endif

                <div class="card mt-3">
                    <div class="card-header">
                        <h4>Permissions
                            @can('create permission')
                                <a href="{{ url('permissions/create') }}" class="btn btn-sm btn-primary float-end">Add Permission</a>
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
                                @foreach ($permissions as $permission)
                                    <tr>
                                        <td>{{ $permission->id }}</td>
                                        <td>{{ $permission->name }}</td>
                                        <td>
                                            @can('update permission')
                                                <a href="{{ route('permissions.edit', $permission->id) }}"
                                                    class="btn btn-info btn-sm bi-pencil-square"></a>
                                            @endcan

                                            @can('delete permission')
                                                <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm bi-trash-fill"
                                                        onclick="return confirm('Are you sure you want to delete this permission?')"></button>
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
