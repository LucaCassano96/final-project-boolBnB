<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>BoolBnB</title>

    {{-- stylesheet --}}
    <link rel="stylesheet" href="{{ asset('scss/app.scss') }}">

    {{-- fontawesome --}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Usando Vite -->
    @vite(['resources/js/app.js'])
</head>

<body>
    <div id="app" style="background-color: #2d3047">

        <nav class=" p-4 navbar navbar-expand-md navbar-light shadow-sm"
            style="background-color: #2d3047; height: 100px">

            <div class="container">

                <div class="d-flex justify-content-between" id="navbarSupportedContent" style="width: 100%">
                    <!-- Left Side Of Navbar -->

                        <h1 class="logo-bnb">
                            <a style="color: #fffdeb" href="{{ url('/') }}"><i class="bi bi-house-heart-fill"></i> BoolBnB </a>
                        </h1>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav">

                        {{-- VISUALIZZAZIONE GUEST --}}
                        @guest
                            <li class="nav-item login-link-1">
                                <a class="nav-link hover-uline " style="color:#fffdeb"
                                    href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item login-link-2 ">
                                    <a class="nav-link hover-uline" style="color:#fffdeb"
                                        href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown  text-start z-1 ">
                                <a id="navbarDropdown" style="color:#fffdeb" class="nav-link dropdown-toggle "
                                    href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false" v-pre>
                                    <i class="bi bi-person-circle"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end " style="background-color: #E0A458"
                                    aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item text-decoration-none"
                                        href="{{ url('dashboard') }}">{{ __('I miei appartamenti') }}</a>
                                    <a class="dropdown-item text-decoration-none"
                                        href="{{ url('profile') }}">{{ __('Profilo') }}</a>
                                    <a class="dropdown-item text-decoration-none" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Esci') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main style="background-color: #2d3047; min-height: calc(100vh - 100px)">
            @yield('content')
        </main>
    </div>
</body>

</html>
