<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Session\Session;
use Illuminate\Notifications\Notification;
use App\Notifications\CustomResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;



class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;

    protected $connection = 'oracle'; // nombre de la conexion que se configuro en el archivo database.php

    protected $table = 'biblioteca_virtual.usuario_panel';

    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'usuario',
        'personas_id',
        'perfil_id',
        'correo_electronico',
        'fecha_ingreso',
        'descripcion',
        'activo',
        'usuario_id_mod',
        'establecimiento_id',
        'estab_unid_func_id',
        'unidad_funcional_origen_id',
        'proyecto_predeterminado',
        'alias',
        'run',
        'ultimo_acceso',
        'habilita_depuracion',
        'fecha_clave',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'clave',
    ];

    /**
     * este metodo es para que laravel busque por el campo clave para los que seautentican desde afuera, metodo implementado en laravel 11
     */
    public function getAuthPasswordName()
    {
        return 'clave';
    }

    public function getEmailForPasswordReset()
    {
        return $this->correo_electronico;
    }
    public function session()
    {
        return $this->hasMany(Session::class);
    }
    public function routeNotificationForMail(Notification $notification): array|string
    {
        // Return email address only...
        //return $this->email_address;

        // Return email address and name...
        return [$this->correo_electronico => $this->run];
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPasswordNotification($token));
    }

    public function findForPassport($username)
    {
        return $this->where('run', $username)->first();
    }

    public function validateForPassportPasswordGrant(string $password): bool
    {
        return Hash::check($password, $this->clave);
    }

    public function hasRole($role)
    {
        $this->perfil_id = 'admin';
        return $this->perfil_id == $role;
    }

    public function hasApp()
    {
        return ['cliente2', 'cliente3'];
    }

    public function tokenCan($scope)
    {
        return $this->accessToken ? $this->accessToken->can($scope) : false;
    }

    public function token()
    {
        return $this->accessToken;
    }

    /**
     *  Relaciones de la tabla
     */
     public function realms(){
         return $this->belongsToMany(Realm::class, 'realm_user', 'user_id', 'realm_id');
     }



}
