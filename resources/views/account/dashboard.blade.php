@extends('layouts.account.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header title">Sistemas de Servicio de Salud del Biobio</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <!--<pre>{{ print_r($user->toArray(), true) }}</pre>-->

                    <p>Aplicaciones autorizadas para el usuario:</p>
                    <ul>
                        <li>{{ $clientes['cliente2'] ? 'Aplicación 2 - Cliente2 activo' : 'Aplicación 2 - Cliente2
                            Inactivo'}}</li>
                        <li>{{ $clientes['cliente3'] ? 'Aplicación 3 - Cliente3 activo' : 'Aplicación 3 - Cliente3
                            Inactivo'}}</li>
                    </ul>
                </div>
            </div>
            <div class="row mt-3">

            </div>
            <!-- Additional Cards -->
            <div class="row mt-3">
                <x-card title="Aplicación 1" client="Cliente 2" url="http://cliente2.test/" />
                <x-card title="Aplicación 2" client="Cliente 3" url="http://cliente3.test/" />
                <x-card title="Aplicación 3" client="Panel V2" url="http://10.8.117.112/" />
                <x-card title="Aplicación 4" client="Panel V3" url="http://panel_ver_3.test/" />
                <x-card title="Aplicación 5" client="SAC" url="http://panel_ver_3.test/" />
                <x-card title="Aplicación 6" client="APS" url="http://10.8.117.55/" />
            </div>
        </div>
        <div class="col-md-12" style="display: none">
            <p>Test.</p>
            <p>1.- Scopes en Passport , mostrar solo las aplicaciones que el usuario tiene autorización.</p>
            <p>2.- Probar que pasa cuando el usuario tiene autorizacion para varias aplicaciones y cada una de ella
                depende de un modelo User diferente.</p>
            <p>3.- Agregar un cambio de contraseña al menu general.</p>
            <p>4.- Gestionar las sesiones habilitadas y poder cerrarlas.</p>
            <p>5.- Agregar Catcha.</p>
            <p>6.- purga de registros obsoletos (Ejm. tokéns revocados).</p>
            <p>7.- .</p>

        </div>
    </div>
</div>
@endsection