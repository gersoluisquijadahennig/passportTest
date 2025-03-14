@extends('layouts.account.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <div class="card">
                <div class="accessibility-buttons">
                    <button onclick="toggleTheme()" class="btn btn-secondary">
                        <i id="theme-icon" class="fa fa-moon"></i>
                    </button>
                    <button onclick="increaseFontSize()" class="btn btn-secondary">A+</button>
                    <button onclick="decreaseFontSize()" class="btn btn-secondary">A-</button>
                </div>
                <div class="card-header title text-center">
                    Acceso único a sistemas del SSBB
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login.account') }}" novalidate onsubmit="cleanRut()">
                        @csrf
                        <div class="row mb-3">
                            <label for="run" class="col-md-4 col-form-label text-md-end">R.u.t</label>
                            <div class="col-md-6">
                                <input
                                    id="run"
                                    type="text"
                                    class="form-control @error('run') is-invalid @enderror"
                                    name="run"
                                    value="{{ app()->environment('local') ? '26.335.451-6' : old('run') }}"
                                    required
                                    autocomplete="off"
                                    autofocus
                                    oninput="formatearRut(this)"
                                >
                                @error('run')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">Clave</label>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <input
                                        id="password"
                                        type="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        name="password"
                                        value="{{ app()->environment('local') ? '123123123' : old('password') }}"
                                        required
                                        autocomplete="off"
                                    >
                                    <button class="btn btn-outline-secondary" type="button" id="button-addon2" onclick="togglePasswordVisibility()">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary" id="login-button">
                                    {{ __('Ingresar') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        Recuperar mi clave
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function formatearRut(input) {
        var rut = input.value.replace(/[^0-9kK]/g, '').toUpperCase();
        if (rut.length > 9) {
            rut = rut.slice(0, 9);
        }
        if (rut.length > 1) {
            rut = rut.slice(0, -1).replace(/\B(?=(\d{3})+(?!\d))/g, ".") + '-' + rut.slice(-1);
        }
        input.value = rut;
    }

    function cleanRut() {
        var runInput = document.getElementById('run');
        runInput.value = runInput.value.replace(/[.-]/g, '');
    }

    function togglePasswordVisibility() {
        var passwordInput = document.getElementById('password');
        var passwordButton = document.getElementById('button-addon2');
        var icon = passwordButton.querySelector('i');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    function toggleTheme() {
        const html = document.documentElement;
        const icon = document.getElementById('theme-icon');

        let isDarkMode = html.getAttribute('data-bs-theme') === 'dark';

        if (isDarkMode) {
            html.setAttribute('data-bs-theme', 'light');
            localStorage.setItem('theme', 'light');
            icon.classList.remove('fa-sun');
            icon.classList.add('fa-moon');
        } else {
            html.setAttribute('data-bs-theme', 'dark');
            localStorage.setItem('theme', 'dark');
            icon.classList.remove('fa-moon');
            icon.classList.add('fa-sun');
        }
    }

    function increaseFontSize() {
        var body = document.body;
        var style = window.getComputedStyle(body, null).getPropertyValue('font-size');
        var currentSize = parseFloat(style);
        if (currentSize < 24) {
            body.style.fontSize = (currentSize + 1) + 'px';
        }
    }

    function decreaseFontSize() {
        var body = document.body;
        var style = window.getComputedStyle(body, null).getPropertyValue('font-size');
        var currentSize = parseFloat(style);
        if (currentSize > 15) {
            body.style.fontSize = (currentSize - 1) + 'px';
        }
    }

    // Aplicar el modo oscuro si estaba activado antes
    (function () {
        const theme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-bs-theme', theme);
        const icon = document.getElementById('theme-icon');
        if (theme === 'dark') {
            icon.classList.remove('fa-moon');
            icon.classList.add('fa-sun');
        } else {
            icon.classList.remove('fa-sun');
            icon.classList.add('fa-moon');
        }
    })();
</script>

<style>
    .accessibility-buttons {
        position: absolute;
        right: 10px;
        display: flex;
        gap: 5px;
        top: -30px;
    }
</style>
@endsection
