<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app['auth']->provider('CustomEloquent', function ($app, array $config) {
            $model=$app['config']['auth.providers.users.model'];
            return new CustomEloquentUserProvider($app['hash'], $model);
        });
    }
}
