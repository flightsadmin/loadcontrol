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
                        <h4>Edit User</h4>
                        <a href="{{ url('users') }}" class="btn btn-sm btn-danger">Back</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('users/' . $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" id="name" value="{{ $user->name }}" class="form-control @error('name') is-invalid @enderror" />
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" value="{{ $user->email }}" class="form-control" readonly />
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">New Password (optional)</label>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" />
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="roles" class="form-label">Roles</label>
                                <div class="row">
                                    @foreach ($roles as $role)
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input type="checkbox" name="roles[]" value="{{ $role }}" class="form-check-input"
                                                    id="role-{{ $role }}" {{ in_array($role, $userRoles) ? 'checked' : '' }}>
                                                <label for="role-{{ $role }}" class="form-check-label">
                                                    {{ $role }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @error('roles')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
