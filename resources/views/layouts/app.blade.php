<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <div class="container-fluid">
            <div class="row">
                @auth
                    <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-dark-subtle sidebar shadow-sm vh-100">
                        <div class="d-flex flex-column h-100">
                            <div class="position-sticky top-0 border-bottom bg-dark-subtle">
                                <div class="d-flex justify-content-between align-items-center m-2">
                                    <form method="GET" action="{{ route('flights.index') }}" class="d-flex">
                                        <input type="date" name="date" class="form-control form-control-sm" id="date-picker"
                                            value="{{ old('date', session('selectedDate')) }}">
                                        <button type="submit" class="btn btn-link p-0 bi-funnel-fill ms-3 text-reset"></button>
                                    </form>
                                    <a href="{{ route('flights.create') }}" class="btn-link text-secondary bi-plus-circle-fill"></a>
                                </div>
                            </div>

                            <div class="overflow-auto flex-grow-1">
                                <ul class="nav flex-column">
                                    @isset($flights)
                                        @forelse ($flights as $f)
                                            <li class="nav-item text-body-dark">
                                                <a class="nav-link {{ isset($flight) && $flight->id == $f->id ? 'active bg-secondary text-white' : '' }} text-reset"
                                                    href="{{ route('flights.show', ['flight' => $f->id, 'page' => request()->query('page')]) }}">
                                                    {{ $f->flight_number }} - {{ $f->departure->format('dS, M Y') }}
                                                </a>
                                            </li>
                                        @empty
                                            <li class="nav-item text-body-dark mt-3">
                                                <h5 class="mx-2 fw-medium">No Flights Available</h5>
                                            </li>
                                        @endforelse
                                    @else
                                        <p class="mt-4 fw-medium">Flights Not Loaded.</p>
                                    @endisset
                                </ul>
                            </div>
                            <div class="dropdown mt-auto mb-3">
                                {{ $flights->links() }}
                                <hr>
                                <a href="#" class="d-flex align-items-center text-center text-reset text-decoration-none dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <strong>{{ auth()->user()->name }}</strong>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                                    <li>
                                        <form action="{{ route('migrate') }}" method="GET" style="margin: 0;">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                Seed Database
                                            </button>
                                        </form>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Edit Profile</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                      document.getElementById('logout-form').submit();">
                                            {{ __('Sign Out') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                @endauth

                <main class="col-md-9 ms-sm-auto col-lg-10 px-4 vh-100 overflow-auto">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
    @yield('scripts')
</body>

</html>
