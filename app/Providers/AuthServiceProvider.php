<?php

namespace App\Providers;

use App\Hashing\Md5Hasher;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Passwords\PasswordBrokerManager;
use App\Http\Controllers\Auth\CustomAccesTokenController;
use Laravel\Passport\Http\Controllers\AccessTokenController;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        /*$this->app->singleton('md5hash', function ($app) {
            return new Md5Hasher();
        });*/
        $this->app->bind(AccessTokenController::class, CustomAccesTokenController::class);

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app['auth']->provider('CustomEloquent', function ($app) {
            $model = $app['config']['auth.providers.users.model'];
            // Create MD5 hasher instance only for CustomEloquent provider
            $md5Hasher = new Md5Hasher();
            return new CustomEloquentUserProvider($md5Hasher, $model);
        });
    }
}
