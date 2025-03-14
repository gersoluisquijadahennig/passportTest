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


En el caso que de que necesitemos que el tipo de cliente sea passport en el appserviceprovider

    public function boot(): void
    {
        //Passport::useClientModel(Client::class);
        Passport::enablePasswordGrant();
    }


Si se instalo la libreria de Oci para laravel
Se instala el paquete jeremy379/laravel-openid-connect


Laravel Passport ahora es un Idp (Identity provider) proveedor de identidad, implementamos OpenID Connect en Laravel Passport, ahora no necesitamos realizar llamadas adicionales a la apu de passport para obtener datos del usuario, ahora podemos obtener los datos directamente en el id_token.

CLAVE PUBLICA EXPUESTA - VERIFICAR EL PROCESO
ahora tenemos un nuevo recurso /oauth/jwks que nos devuelve las claves publicas para validar el token JWT, validar el token en los clientes es muy sencillo, solo necesitamos la clave publica y el token JWT, con esto podemos validar el token JWT en el cliente.


recordar que tenemos que solicitar el token en la ruta con el scope ['openid']	Obligatorio en OIDC. Indica que se solicita autenticación y generación de un id_token, adicionalmente se enviará en el scope cualquier valor que este en el claims scope del id_token.

al igual que keycloak, podemos tener un cliente de administración de cuentas que nos permita gestionar los usuarios. revisar

la duracion de la session del cliente deberia de durar lo mismo que la duracion del token, hay que investigar que pasa cuando queremos que la session sea dinamica.

tenemos que separar las rutas del oauth, con diferentes guards, en web rutas para usuarios administrador y rutas account para usuarios.
en este proyecto si especificar bien la separacion de los esquemas 