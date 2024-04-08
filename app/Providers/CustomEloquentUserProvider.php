<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Auth\EloquentUserProvider;

class CustomEloquentUserProvider extends EloquentUserProvider
{

    public function validateCredentials(UserContract $user, array $credentials)
    {
        //dd($credentials);
        if (is_null($plain = $credentials['password'])) {
            return false;
        }else{
            $plain = $credentials['password'];
        }

        //dd(hash('md5', $plain).' == '.$user->getAuthPassword());
        return hash('md5', $plain) === $user->getAuthPassword();
    }
    

    /*public function validateCredentials(UserContract $user, array $credentials)
    {
        if (is_null($plain = $credentials['password'])) {
            return false;
        }

        return $this->hasher->check($plain, $user->getAuthPassword());
    }*/

}
