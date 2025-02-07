<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Session\Session;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $connection = 'oracle'; // nombre de la conexion que se configuro en el archivo database.php

    protected $table = 'biblioteca_virtual.usuario_panel';

    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'clave',
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

}
