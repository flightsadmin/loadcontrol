@extends('layouts.app')

@section('content')
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="card shadow" style="width: 450px;">
            <div class="card-body">
                <h5 class="text-center mb-4">{{ __('Login') }}</h5>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Email Address') }}</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">{{ __('Login') }}</button>
                </form>

                @if (\App\Models\User::count() == 0 && Route::has('register'))
                    <div class="text-center mt-3">
                        <a class="btn btn-primary" href="{{ route('register') }}">
                            {{ __('Register?') }}
                        </a>
                    </div>
                @endif

                @if (Route::has('password.request'))
                    <div class="text-center mt-3">
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
