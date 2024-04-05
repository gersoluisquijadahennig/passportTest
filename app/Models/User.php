<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    protected $connection = 'oracle';

    /**
     * eliminamos que create_at and modified_at
     */
   
    protected $table = 'BIBLIOTECA_VIRTUAL.USUARIO_PANEL';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'usuario',
        'clave',
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

    public function findForPassport(string $username): User
    {
        return $this->where('run', $username)->first();
    }
    public function getAuthPasswordName()
    {
        return 'clave';
    }
}
