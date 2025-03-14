<?php

namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class CustomEloquentUserProvider extends EloquentUserProvider
{
    // quizas no fue necesario extender de EloquentUserProvider porque con solo agregar un hash personalizado en AppServiceProvider.php era suficiente para continuar con el flujo de autenticación.
}
