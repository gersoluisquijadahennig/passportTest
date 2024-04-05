<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class PanelUser extends Authenticatable
{
    use  HasApiTokens;
   
    protected $connection = 'oracle';
    
    protected $table = 'BIBLIOTECA_VIRTUAL.USUARIO_PANEL';

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

    protected $hidden = [
        'clave',
    ];
    public function getAuthPasswordName()
    {
        return 'clave';
    }
    



}
