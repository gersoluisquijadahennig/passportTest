<?php

return [
    'passport' => [

        /**
         * Coloca aquí tus scopes de Passport y OpenID Connect.
         * Para recibir un `id_token`, debes proporcionar al menos el scope 'openid'.
         */
        'tokens_can' => [
            'openid' => 'Habilitar OpenID Connect',
            'profile' => 'Información sobre tu perfil',
            'email' => 'Información sobre tu dirección de correo',
            'phone' => 'Información sobre tus números telefónicos',
            'address' => 'Información sobre tu dirección',
            // 'login' => 'Ver tu información de inicio de sesión',
        ],
    ],

    /**
     * Coloca aquí tus conjuntos de claims personalizados.
     */
    'custom_claim_sets' => [
        // 'login' => [
        //     'last-login',
        // ],
        // 'company' => [
        //     'company_name',
        //     'company_address',
        //     'company_phone',
        //     'company_email',
        // ],
    ],

    /**
     * Puedes sobrescribir los repositorios a continuación.
     */
    'repositories' => [
        'identity' => \OpenIDConnect\Repositories\IdentityRepository::class,
    ],

    'routes' => [
        /**
         * Cuando está establecido en true, este paquete expondrá el endpoint de Descubrimiento de OpenID Connect.
         *  - /.well-known/openid-configuration
         */
        'discovery' => true,
        /**
         * Cuando está establecido en true, este paquete expondrá el endpoint del Conjunto de Claves Web JSON.
         */
        'jwks' => true,
         /**
          * URL opcional para cambiar la ruta JWKS para alinearse con tus rutas personalizadas de Passport.
          * Por defecto es /oauth/jwks
          */
        'jwks_url' => '/oauth/jwks',
    ],

    /**
     * Configuración para el endpoint de descubrimiento
     */
    'discovery' => [
        /**
        * Ocultar los scopes que no son de la especificación OpenID Core del Descubrimiento,
        * por defecto = false (se listan todos los scopes)
        */
        'hide_scopes' => false,
    ],

    /**
     * El firmante que se utilizará
     */
    'signer' => \Lcobucci\JWT\Signer\Rsa\Sha256::class,

    /**
     * Array asociativo opcional que se utilizará para establecer encabezados en el JWT
     */
    'token_headers' => [],

    /**
     * Por defecto, se incluyen los microsegundos.
     */
    'use_microseconds' => true,

    /**
     * Valor para los parámetros issuedBy. Por defecto: 'laravel' para obtener el esquema y host de la variable $_SERVER.
     * Opciones: laravel (usa Request para extraer esquema y host), server (usa $_SERVER para detectar)
     * o cualquier otra cadena que se usará tal cual
     */
    'issuedBy' => 'laravel',
];