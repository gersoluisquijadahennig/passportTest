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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app-laravel.js'])
</head>
<body class="flex flex-col min-h-screen">
    <div id="app" class="flex-grow">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm relative">
            <div class="absolute top-0 left-0 p-2">
                <div class="franja">
                    <span class="franjaazul"></span>
                    <span class="franjaroja"></span>
                </div>
            </div>
            <div class="container">

                <a class="navbar-brand" href="{{ url('/account/dashboard') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->alias }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout.admin') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Salir') }}
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        {{ __('Perfil') }}
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        {{ __('Teams') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout.admin') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>

    </div>
    <div class="container text-center" style="font-size: 0.6rem;">
            Servicio de Salud Biobío, Departamento de Tecnologías de la Información y de las Comunicaciones
    </div>
    <footer class="bg-dark text-white py-4">

        <div class="container">
            <div class="row align-items-center text-center text-md-start">
                <!-- Sección Izquierda -->
                <div class="col-12 col-md-4 mb-3 mb-md-0 d-flex justify-content-center justify-content-md-start">
                    <img src="{{ asset('/img/logo_prueba_izquierda.svg') }}" alt="Logo" class="img-fluid" style="height: 64px;">
                </div>

                <!-- Sección Central -->
                <div class="col-12 col-md-4 mb-3 mb-md-0 text-left">
                    <p class="mb-2">Recursos</p>
                    <ul class="list-unstyled">
                        <li><a href="{{url('/developer')}}" class="text-white text-decoration-none">Documentación</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Integraciones</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Link 3</a></li>
                    </ul>
                </div>

                <!-- Sección Derecha -->
                <div class="col-12 col-md-4 d-flex justify-content-center justify-content-md-end">
                    <img src="{{ asset('/img/logo_prueba.svg') }}" alt="Logo" class="img-fluid" style="height: 64px;">
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
