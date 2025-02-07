<?php

namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class CustomEloquentUserProvider extends EloquentUserProvider
{

    /*public function validateCredentials(UserContract $user, array $credentials)
    {
        //dd($credentials);
        if (is_null($plain = $credentials['password'])) {
            return false;
        }

        if(config('database.default') == 'pgsql'){
            return hash('md5', $plain) === $user->getAuthPassword();
            //return $this->hasher->check($plain, $user->getAuthPassword());
        }else{
            return hash('md5', $plain) === $user->getAuthPassword();
        }

    }*/

}
