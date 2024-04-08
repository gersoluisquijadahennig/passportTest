<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    protected $connection = 'oracle';
   
    protected $table = 'BIBLIOTECA_VIRTUAL.USUARIO_PANEL';

    public $timestamps = true;

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

}
