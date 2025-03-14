<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Client;
use App\Hashing\MD5Hasher;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\Hash;
use Laravel\Passport\TokenRepository;

use Illuminate\Support\ServiceProvider;
use App\Repositories\DatabaseRedisTokenRepository;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //$this->app->singleton(TokenRepository::class, DatabaseRedisTokenRepository::class);
        //$this->app->register(\Laravel\Passport\PassportServiceProvider::class);
        $this->app->register(\OpenIDConnect\Laravel\PassportServiceProvider::class);

        if ($this->app->environment('local') && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Passport::useClientModel(Client::class);
        Passport::enablePasswordGrant();
        //Passport::tokensExpireIn(now()->addMinute(1));
        //Passport::refreshTokensExpireIn(now()->addMinutes(2));
        Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));

        /*$this->app['auth']->provider('CustomEloquent', function ($app, array $config) {
            $model=$app['config']['auth.providers.users.model'];
            return new CustomEloquentUserProvider($app['hash'], $model);
        });*/
        // quizas se usa para funciones mas adelante. agregar un customEloquent.


        Hash::extend('md5', function () {
            return new MD5Hasher;
        });

        Gate::define('cliente_3', function (User $user) {
            // agregar logica para buscar la condicion en las tablas de la base de datos
            //$active = $user->activo;
            $active = 'S';
            return $active === 'S';
        });

        Gate::define('cliente_2', function (User $user) {
            //$active = $user->activo;
            $active = 'S';
            return $active === 'S';
        });

        $scopes_custom = [
            'cliente2' => 'Permiso de acceso a la aplicación Cliente 2',
            'cliente3' => 'Permiso de acceso a la aplicación Cliente 3',
        ];

        $scopes = array_merge($scopes_custom, config('openid.passport.tokens_can'));

        Passport::tokensCan($scopes);

        /*Passport::setDefaultScope([
            'check-status',
            'place-orders',
        ]);*/


    }
}
