<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class UserAdmin extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles, HasFactory;

    protected $guard = 'admin';
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = ['*'];
    // create_at and update_at columns are not needed
    public $timestamps = true;

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getAuthIdentifierName()
    {
        return 'rut';
    }

    public function realms(){
        return $this->belongsToMany(Realm::class, 'realm_user', 'user_id', 'realm_id');
    }
}