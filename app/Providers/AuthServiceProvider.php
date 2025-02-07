<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Hashing\Md5Hasher;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('md5hash', function ($app) {
            return new Md5Hasher();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app['auth']->provider('CustomEloquent', function ($app) {
            $model=$app['config']['auth.providers.users.model'];
            return new CustomEloquentUserProvider($app['md5hash'], $model);
        });
    }
}
