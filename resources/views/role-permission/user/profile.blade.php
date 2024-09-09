@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Profile</h1>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>
                <div class="col-md-6">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                        value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>
                <div class="col-md-6">
                    <input id="email" type="email" readonly class="form-control @error('email') is-invalid @enderror" name="email"
                        value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="password" class="col-md-4 col-form-label text-md-end">New Password (optional)</label>
                <div class="col-md-6">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="password_confirmation" class="col-md-4 col-form-label text-md-end">Confirm Password</label>
                <div class="col-md-6">
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation">
                </div>
            </div>

            <div class="row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-sm btn-primary float-end bi-floppy"> Update Profile </button>
                </div>
            </div>
        </form>
    </div>
@endsection
