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


        <nav class="navbar navbar-expand-md navbar-light shadow-sm" style="background-color: #2d3047; height: 100px">
            <div class="container">


                <button style="border-color: #fffdeb;" class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse d-flex justify-content-between" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <a class="navbar-brand" style="color: #fffdeb" href="{{ url('/') }}">
                        <div class="logo_laravel">
                            <h1 class="logo-bnb">
                                <i class="bi bi-house-heart-fill"></i>
                                BoolBnB
                            </h1>
                        </div>
                        {{-- config('app.name', 'Laravel') --}}
                    </a>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav text-end">
                        <!-- Authentication Links -->

                        {{-- VISUALIZZAZIONE GUEST --}}
                        @guest
                        <li class="nav-item login-link-1">
                            <a class="nav-link hover-uline" style="color:#fffdeb" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item login-link-2">
                            <a class="nav-link hover-uline" style="color:#fffdeb" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" style="color:#fffdeb" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="bi bi-person-circle"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ url('dashboard') }}">{{__('I miei appartamenti')}}</a>
                                <a class="dropdown-item" href="{{ url('profile') }}">{{__('Profilo')}}</a>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
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
