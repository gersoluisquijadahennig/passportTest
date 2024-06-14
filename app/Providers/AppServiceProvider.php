<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use App\Models\Client;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //Passport::useClientModel(Client::class);
        //Passport::enablePasswordGrant();
        //Passport::tokensExpireIn(now()->addDays(15));
        //Passport::refreshTokensExpireIn(now()->addDays(30));
        //Passport::personalAccessTokensExpireIn(now()->addMonths(6));     

        $this->app['auth']->provider('CustomEloquent', function ($app, array $config) {
            $model=$app['config']['auth.providers.users.model'];
            return new CustomEloquentUserProvider($app['hash'], $model);
        });
    }
}
