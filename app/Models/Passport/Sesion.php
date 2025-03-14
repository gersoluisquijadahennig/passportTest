<?php

namespace App\Models\Passport;

use Illuminate\Database\Eloquent\Model;


Class Sesion extends Model
{
    protected $connection = 'pgsql'; // nombre de la conexion que se configuro en el archivo database.php

    protected $table = 'sessions';

    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'user_id',
        'ip_address',
        'user_agent',
        'payload',
        'last_activity',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */


     
}