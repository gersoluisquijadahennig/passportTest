@extends('layouts.admin.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Dashboard</h1>
            <p>Welcome to the admin dashboard</p>
        </div>
    </div>
    <div class="row">
        <ul>
            <li><a href="#">Realm / Team's Spatie</a></li>
            <li><a href="#">Users</a></li>
            <li><a href="#">Roles</a></li>
            <li><a href="#">Permissions</a></li>
        </ul>

        <h2> Administración de Clientes </h2>
        <ul>
            <li><a href="#">Clientes</a></li>
            <li><a href="#">Crear Cliente</a></li>
        </ul>
    </div>
</div>
@endsection