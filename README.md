## Documentacion 
[¿Qué concesión de OAuth 2.0 debo implementar?](    https://documenter.getpostman.com/view/10808729/SzS8rjbc?version=latest)

## Cliente de concesion de contraseña

El cliente de concesión de contraseña se utiliza en el flujo de concesión de contraseña de OAuth 2.0. Este flujo permite a los clientes de confianza obtener un token de acceso utilizando sus propias credenciales de usuario (nombre de usuario y contraseña).

Este flujo es útil en situaciones donde el cliente es altamente confiable y donde otros flujos de autorización no son prácticos. Un ejemplo común es una aplicación móvil o de escritorio desarrollada por el mismo equipo que desarrolla la API.

Aquí está el flujo paso a paso:

1. El usuario proporciona su nombre de usuario y contraseña a la aplicación cliente.

2. La aplicación cliente envía estas credenciales al servidor de autorización.

3. Si las credenciales son válidas, el servidor de autorización emite un token de acceso a la aplicación cliente.

4. La aplicación cliente puede usar este token de acceso para hacer solicitudes a la API en nombre del usuario.

Es importante tener en cuenta que este flujo implica que la aplicación cliente tiene que manejar las credenciales del usuario de forma segura. Por esta razón, sólo debe ser utilizado por clientes de confianza.


  Client ID ...................................................................................................................................... 1
  Client secret ........................................................................................... UGM5QM0LMNr6COmBxCYaRMAQCpfhuWL3MLbxb1k3

Al crear el cliente de tipo password nos pregunta que modelo de usuario vamos a utilizar, en este caso el modelo User que viene por defecto en Laravel.
pero es interesante porque podemos utilizar otro modelo de usuario que tengamos en nuestra aplicación.

  PS C:\laragon\www\passport> php artisan passport:client --password

 What should we name the password grant client? [Laravel Password Grant Client]:
 > Panel Confiable

 Which user provider should this client use to retrieve users? [users]:
  [0] users
 >


en el modelo user
     public function findForPassport(string $username): User
    {
        return $this->where('run', $username)->first();
    }


en el appserviceprovider

    public function boot(): void
    {
        //Passport::useClientModel(Client::class);
        Passport::enablePasswordGrant();   
    }
