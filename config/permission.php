<?php

return [

    'models' => [

        /*
         * Cuando se usa el trait "HasPermissions" de este paquete, necesitamos saber qué
         * modelo Eloquent debe usarse para recuperar los permisos. Por supuesto,
         * generalmente es solo el modelo "Permission" pero puedes usar el que prefieras.
         *
         * El modelo que quieras usar como modelo de Permiso debe implementar el
         * contrato `Spatie\Permission\Contracts\Permission`.
         */

        'permission' => Spatie\Permission\Models\Permission::class,

        /*
         * Cuando se usa el trait "HasRoles" de este paquete, necesitamos saber qué
         * modelo Eloquent debe usarse para recuperar los roles. Por supuesto,
         * generalmente es solo el modelo "Role" pero puedes usar el que prefieras.
         *
         * El modelo que quieras usar como modelo de Rol debe implementar el
         * contrato `Spatie\Permission\Contracts\Role`.
         */

        'role' => Spatie\Permission\Models\Role::class,
    ],

    'table_names' => [

        /*
         * Cuando se usa el trait "HasRoles", necesitamos saber qué tabla
         * debe usarse para recuperar los roles. Hemos elegido un valor
         * predeterminado básico, pero puedes cambiarlo fácilmente a cualquier tabla que desees.
         */

        'roles' => 'roles',

        /*
         * Cuando se usa el trait "HasPermissions", necesitamos saber qué tabla
         * debe usarse para recuperar los permisos. Hemos elegido un valor
         * predeterminado básico, pero puedes cambiarlo fácilmente a cualquier tabla que desees.
         */

        'permissions' => 'permissions',

        /*
         * Cuando se usa el trait "HasPermissions", necesitamos saber qué tabla
         * debe usarse para recuperar los permisos de los modelos. Hemos elegido un valor
         * predeterminado básico, pero puedes cambiarlo fácilmente a cualquier tabla que desees.
         */

        'model_has_permissions' => 'model_has_permissions',

        /*
         * Cuando se usa el trait "HasRoles", necesitamos saber qué tabla
         * debe usarse para recuperar los roles de los modelos. Hemos elegido un valor
         * predeterminado básico, pero puedes cambiarlo fácilmente a cualquier tabla que desees.
         */

        'model_has_roles' => 'model_has_roles',

        /*
         * Cuando se usa el trait "HasRoles", necesitamos saber qué tabla
         * debe usarse para recuperar los permisos de los roles. Hemos elegido un valor
         * predeterminado básico, pero puedes cambiarlo fácilmente a cualquier tabla que desees.
         */

        'role_has_permissions' => 'role_has_permissions',
    ],

    'column_names' => [
        /*
         * Cambia esto si quieres nombrar las tablas pivote relacionadas de forma diferente a los valores predeterminados
         */
        'role_pivot_key' => null, // predeterminado 'role_id',
        'permission_pivot_key' => null, // predeterminado 'permission_id',

        /*
         * Cambia esto si quieres nombrar la clave primaria del modelo relacionado de forma diferente a
         * `model_id`.
         *
         * Por ejemplo, esto sería útil si todas tus claves primarias son UUIDs. En
         * ese caso, nómbralo `model_uuid`.
         */

        'model_morph_key' => 'model_id',

        /*
         * Cambia esto si quieres usar la función de equipos y la clave foránea
         * de tu modelo relacionado es diferente a `team_id`.
         */

        'team_foreign_key' => 'team_id',
    ],

    /*
     * Cuando se establece en true, el método para verificar permisos se registrará en el gate.
     * Establece esto en false si quieres implementar una lógica personalizada para verificar permisos.
     */

    'register_permission_check_method' => true,

    /*
     * Cuando se establece en true, se registrará el listener del evento Laravel\Octane\Events\OperationTerminated
     * esto actualizará los permisos en cada TickTerminated, TaskTerminated y RequestTerminated
     * NOTA: Esto no debería ser necesario en la mayoría de los casos, pero una combinación de Octane/Vapor se benefició de ello.
     */
    'register_octane_reset_listener' => false,

    /*
     * Los eventos se dispararán cuando se asigne/desasigne un rol o permiso:
     * \Spatie\Permission\Events\RoleAttached
     * \Spatie\Permission\Events\RoleDetached
     * \Spatie\Permission\Events\PermissionAttached
     * \Spatie\Permission\Events\PermissionDetached
     *
     * Para habilitarlos, establece en true, y luego crea listeners para observar estos eventos.
     */
    'events_enabled' => false,

    /*
     * Función de Equipos.
     * Cuando se establece en true, el paquete implementa equipos usando 'team_foreign_key'.
     * Si quieres que las migraciones registren 'team_foreign_key', debes
     * establecer esto en true antes de hacer la migración.
     * Si ya hiciste la migración, debes hacer una nueva migración para agregar
     * 'team_foreign_key' a 'roles', 'model_has_roles', y 'model_has_permissions'
     * (ver la última versión del archivo de migración de este paquete)
     */

    'teams' => true,

    /*
     * La clase a usar para resolver el ID del equipo de permisos
     */
    'team_resolver' => \Spatie\Permission\DefaultTeamResolver::class,

    /*
     * Credenciales de Cliente de Passport
     * Cuando se establece en true, el paquete usará el Cliente de Passport para verificar permisos
     */

    'use_passport_client_credentials' => false,

    /*
     * Cuando se establece en true, los nombres de los permisos requeridos se agregan a los mensajes de excepción.
     * Esto podría considerarse una fuga de información en algunos contextos, por lo que la configuración
     * predeterminada es false aquí para una seguridad óptima.
     */

    'display_permission_in_exception' => false,

    /*
     * Cuando se establece en true, los nombres de los roles requeridos se agregan a los mensajes de excepción.
     * Esto podría considerarse una fuga de información en algunos contextos, por lo que la configuración
     * predeterminada es false aquí para una seguridad óptima.
     */

    'display_role_in_exception' => false,

    /*
     * Por defecto, la búsqueda de permisos con comodines está deshabilitada.
     * Consulta la documentación para entender la sintaxis soportada.
     */

    'enable_wildcard_permission' => false,

    /*
     * La clase a usar para interpretar permisos con comodines.
     * Si necesitas modificar los delimitadores, sobrescribe la clase y especifica su nombre aquí.
     */
    // 'permission.wildcard_permission' => Spatie\Permission\WildcardPermission::class,

    /* Configuraciones específicas de caché */

    'cache' => [

        /*
         * Por defecto, todos los permisos se almacenan en caché durante 24 horas para mejorar el rendimiento.
         * Cuando se actualizan los permisos o roles, la caché se limpia automáticamente.
         */

        'expiration_time' => \DateInterval::createFromDateString('24 hours'),

        /*
         * La clave de caché usada para almacenar todos los permisos.
         */

        'key' => 'spatie.permission.cache',

        /*
         * Opcionalmente puedes indicar un driver de caché específico para usar en el almacenamiento
         * de permisos y roles usando cualquiera de los drivers `store` listados en el archivo de configuración cache.php.
         * Usar 'default' aquí significa usar el `default` establecido en cache.php.
         */

        'store' => 'default',
    ],
];