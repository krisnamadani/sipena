<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('iain.png') }}" type="image/x-icon">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        .sidebar {
            min-height: calc(100vh - 56px);
            background-color: #f8f9fa;
        }

        .nav-link.active {
            background-color: #0d6efd;
            color: white !important;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .app-logo {
            width: 40px;
            height: 40px;
            object-fit: contain;
        }
    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/dashboard') }}">
                    <img src="{{ asset('iain.png') }}" alt="Logo" class="app-logo">
                    <strong>{{ config('app.name', 'Validasi Belanja') }}</strong>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            @auth
                <div class="container-fluid">
                    <div class="row">
                        <nav class="col-md-2 d-md-block sidebar p-3">
                            <div class="position-sticky">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                                            href="{{ route('dashboard') }}">
                                            📊 Dashboard
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('akun-belanja.*') ? 'active' : '' }}"
                                            href="{{ route('akun-belanja.index') }}">
                                            💰 Akun Belanja
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('validasi.*') ? 'active' : '' }}"
                                            href="{{ route('validasi.index') }}">
                                            ✅ Validasi Data
                                        </a>
                                    </li>
                                    @if (auth()->user()->isSuperAdmin())
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}"
                                                href="{{ route('users.index') }}">
                                                👥 Manajemen User
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </nav>

                        <main class="col-md-10 ms-sm-auto px-md-4 py-4">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            @if (session('warning'))
                                <div class="alert alert-warning alert-dismissible fade show">
                                    {{ session('warning') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            @yield('content')
                        </main>
                    </div>
                </div>
            @else
                <div class="container py-4">
                    @yield('content')
                </div>
            @endauth
        </main>
    </div>
</body>

</html>
