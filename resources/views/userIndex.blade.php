@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    mostramos la informacion del usuario autenticado
                    @auth
                        {{ Auth::user()->alias }} {{ Auth::user()->run}} {{ Auth::user()->clave}}
                    @endauth
                    @guest
                        <p>Usuario no autenticado</p>
                    @endguest
                    


                    mostramos uns lista de los usuarios de la tabla users
                    <ul>
                        @foreach ($users as $user)
                            <li>{{ $user->alias }} {{ $user->run}} {{ $user->clave}}</li>
                        @endforeach
                    </ul>
                    ahora una lista de los usuario de la tabla userspanel
                    <ul>
                        @foreach ($usersPanel as $userpanel)
                            <li>{{ $userpanel->name }} {{ $userpanel->run}} {{ $userpanel->password}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
