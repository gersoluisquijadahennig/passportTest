<?php

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use App\Http\Middleware\HandleInertiaRequests;
use Laravel\Passport\Http\Middleware\CheckScopes;

use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use Laravel\Passport\Http\Middleware\CheckForAnyScope;
use Laravel\Passport\Http\Middleware\CheckClientCredentials;



return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->web(append: [
            HandleInertiaRequests::class,
        ]);

        $middleware->alias([
            'client' => CheckClientCredentials::class,
            'scopes' => CheckScopes::class,
            'scope' => CheckForAnyScope::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'ensure.realm.access' => \App\Http\Middleware\EnsureRealmAccess::class,
        ]);

        $middleware->redirectGuestsTo(function (Request $request): string {
            if ($request->is('admin/*')) {
                return route('login.admin');
            }
            return route('login.account');
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
