<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
class UserAuth extends Authenticatable
{
    use HasApiTokens;

    protected $connection = 'oracle';


    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = ['run', 'password', 'name', 'email','proyecto','uid'];

    public function getAuthPasswordName()
    {
        return 'password';
    }

     /* podemos hacer un mutador para que el campo uid sea unico y genere un uuid */
    public function setUidAttribute($value)
    {
        $this->attributes['uid'] = (string) \Illuminate\Support\Str::uuid();
    }

    /* quiero combinar dos datos de la tabla para mostrar en la vista  estos metodos se llaman accesores*/

    public function getFullNameAttribute()
    {
        return $this->run . ' - ' . $this->name;
    }

    


}