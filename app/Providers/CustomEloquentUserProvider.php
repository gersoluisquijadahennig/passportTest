<?php

namespace App\Providers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class CustomEloquentUserProvider extends EloquentUserProvider
{

    public function validateCredentials(UserContract $user, array $credentials)
    {
        //dd($credentials);
        if (is_null($plain = $credentials['password'])) {
            return false;
        }

        
        return $this->hasher->check($plain, $user->getAuthPassword());// contra la base de datos de postgres
        //dd(hash('md5', $plain).' == '.$user->getAuthPassword());
        //return hash('md5', $plain) === $user->getAuthPassword();// contra la base de datos de oracle panel
    }
    /**
     * para efectos de 
     */

    /*public function validateCredentials(UserContract $user, array $credentials)
    {
        if (is_null($plain = $credentials['password'])) {
            return false;
        }

        return $this->hasher->check($plain, $user->getAuthPassword());
    }*/

}
