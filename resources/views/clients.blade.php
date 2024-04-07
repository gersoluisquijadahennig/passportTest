@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Clients Oaut SSO SSbiobio</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ url('oauth/clients') }}">
                        @csrf
                        <label for="name">Nombre:</label>
                        <input type="text" id="name" name="name" required>
                        <label for="redirect">Redirect:</label>
                        <input type="text" id="redirect" name="redirect" required>
                        <label for="confidential">Confidencial:</label>
                        <input type="checkbox" id="confidential" name="confidential">
                        <button type="submit">Crear cliente</button>
                    </form>

                    Mostrar los clientes registrados en el sistema Oauth SSO SSbiobio
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Redirección</th>
                                <th>Secret</th>
                                <!-- Agrega aquí más columnas según los datos que quieras mostrar -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                                <tr>
                                    <td>{{ $client->id }}</td>
                                    <td>{{ $client->name }}</td>
                                    <td>{{ $client->redirect }}</td>
                                    <td>{{ $client->secret }}</td>
                                    <!-- Agrega aquí más celdas según los datos que quieras mostrar -->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
