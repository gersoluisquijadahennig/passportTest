<!-- filepath: /C:/laragon/www/oauthssbb/resources/views/developer.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-3">
            <div class="list-group" id="list-tab" role="tablist">
                <a class="list-group-item list-group-item-action active" id="list-intro-list" data-bs-toggle="list" href="#list-intro" role="tab" aria-controls="intro">Introducción</a>
                <a class="list-group-item list-group-item-action" id="list-requisitos-list" data-bs-toggle="list" href="#list-requisitos" role="tab" aria-controls="requisitos">Requisitos previos</a>
                <a class="list-group-item list-group-item-action" id="list-flujo-list" data-bs-toggle="list" href="#list-flujo" role="tab" aria-controls="flujo">Flujo de Autorización OAuth 2.0</a>
                <a class="list-group-item list-group-item-action" id="list-endpoints-list" data-bs-toggle="list" href="#list-endpoints" role="tab" aria-controls="endpoints">Endpoints del Servidor OAuth</a>
                <a class="list-group-item list-group-item-action" id="list-pasos-list" data-bs-toggle="list" href="#list-pasos" role="tab" aria-controls="pasos">Pasos para la Integración del Cliente</a>
                <a class="list-group-item list-group-item-action" id="list-notas-list" data-bs-toggle="list" href="#list-notas" role="tab" aria-controls="notas">Notas Importantes</a>
                <a class="list-group-item list-group-item-action" id="list-problemas-list" data-bs-toggle="list" href="#list-problemas" role="tab" aria-controls="problemas">Problemas comunes</a>
                <a class="list-group-item list-group-item-action" id="list-referencias-list" data-bs-toggle="list" href="#list-referencias" role="tab" aria-controls="referencias">Referencias</a>
            </div>
        </div>
        <div class="col-md-9">
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="list-intro" role="tabpanel" aria-labelledby="list-intro-list">
                    <h5>1. Introducción</h5> <p>Este documento tiene como objetivo proporcionar una guía detallada sobre cómo integrar aplicaciones con el servidor OAuth del Servicio de Salud del Bíobio. El protocolo OAuth es un estándar abierto utilizado para la autorización de aplicaciones de terceros sin necesidad de compartir contraseñas directamente. A través de este flujo de autenticación, los usuarios pueden permitir que aplicaciones accedan a sus datos de manera segura y controlada, sin comprometer su información personal, con consentimiento del usuario el servidor oauth puede interactuar con diferentes servicios o aplicaciones en su nombre. Esta solución es ideal para sistemas donde se requiere un acceso centralizado y controlado, como en el caso de todos los servicios que ofrece el servicio de salud.</p> <p>En el contexto de este servicio, el servidor OAuth permitirá que las aplicaciones que lo necesiten autentiquen a los usuarios y obtengan tokens de acceso para consumir las APIs de manera segura. Este proceso simplificará la experiencia del usuario, pues solo se tendrá que autenticar una vez para acceder a múltiples aplicaciones, cumpliendo con el concepto de <strong>Single Sign-On (SSO)</strong>. De esta forma, se optimiza la gestión de credenciales y se reduce la necesidad de autenticarse repetidamente en cada aplicación.</p> <p>El siguiente flujo de trabajo describe cómo los desarrolladores pueden implementar la autenticación de usuarios utilizando OAuth, de manera que sus aplicaciones puedan integrarse de forma eficiente y segura con el servidor OAuth del Servicio de Salud del Bíobio. Al implementar este sistema, se estará sentando las bases para una implementación más avanzada del SSO, donde los usuarios podrán iniciar sesión en diversas aplicaciones corporativas con un solo token de acceso.</p>
                </div>
                <div class="tab-pane fade" id="list-requisitos" role="tabpanel" aria-labelledby="list-requisitos-list">
                    <h5>Requisitos previos</h5>
                    <p>Para comenzar con la integración, los desarrolladores o clientes deben obtener las siguientes credenciales de acceso del Departamento TIC del Servicio de Salud del Bíobio, que permitirán realizar las solicitudes de autenticación y autorización en el servidor OAuth:</p>
                    <p>Las credenciales necesarias son las siguientes: esto es momentaneo para ir entendiendo el proceso, despues cada cliente podra realizar la gestion de sus clientes autogestinado.</p>
                    <ul class="list-group mb-3">
                        <li class="list-group-item">Client ID: <code>client_id</code> Identificador único de la aplicación cliente.</li>
                        <li class="list-group-item">Client Secret: <code>client_secret</code> Secreto asociado al Client ID, necesario para la autenticación.</li>
                        <li class="list-group-item">Redirect URI(s): <code>redirect_uri</code> URI(s) válidas a las que el servidor OAuth redirigirá después de la autorización, para esto se tiene que enviar la url de los recursos que el cliente tiene habilitados o que tienen la responsabilidad de recibir el <code>authorization_code</code> desde oauth para solicitar el respectivo <code>access_token</code>, por ejemplo si el cliente tiene habilitado el recurso http://dominio-cliente.com/callback.php, deberiamos habilitar http://dominio-cliente/callback.php, para rutas crudas php http://dominio-cliente/callback, para rutas slug amigables</li>
                    </ul>
                    <p>Estas credenciales son necesarias para interactuar con el servidor OAuth y obtener un <strong>token de acceso</strong> que permitirá acceder a las APIs.</p>

                    <img src="{{ asset('/img/grants_oauth.png') }}" alt="OAuth 2.0" class="img-fluid">
                </div>
                <div class="tab-pane fade" id="list-flujo" role="tabpanel" aria-labelledby="list-flujo-list">
                    <h5>3. Flujo de Autorización OAuth 2.0</h5>
                    <p>El flujo de autorización utilizado será el Authorization Code Flow, que es ideal para aplicaciones de servidor (como aplicaciones web) que desean obtener un access token en nombre de un usuario.</p>
                    <p><strong>Flujo de Autorización:</strong></p>
                    <ol class="list-group list-group-numbered mb-3">
                        <li class="list-group-item">
                            <strong>Redirigir al usuario al Authorization Endpoint:</strong>
                            <p>El cliente debe redirigir al usuario a la URL del servidor OAuth para que el usuario se autentique y autorice el acceso. Esta URL tendrá el siguiente formato:</p>
                            <pre><code>https://oauthssbb.test/oauth/authorize?response_type=code&client_id=CLIENT_ID&redirect_uri=REDIRECT_URI&scope=SCOPES&state=RANDOM_STATE</code></pre>
                            <ul>
                                <li><code>response_type=code</code>: El servidor OAuth responderá con un authorization code.</li>
                                <li><code>client_id</code>: El Client ID que te ha proporcionado el Departamento TIC.</li>
                                <li><code>redirect_uri</code>: La URI a la que el usuario será redirigido después de autorizar la solicitud.</li>
                                <li><code>scope</code>: Los permisos solicitados por la aplicación.</li>
                                <li><code>state</code>: Parámetro de seguridad para proteger contra ataques CSRF.</li>
                            </ul>
                        </li>
                        <li class="list-group-item">
                            <strong>Autenticación y autorización del usuario:</strong>
                            <p>El usuario será redirigido a la página de inicio de sesión donde ingresará sus credenciales. Tras autenticarse y autorizar el acceso, el servidor OAuth redirigirá al usuario a la <code>redirect_uri</code> con un authorization code en la URL.</p>
                        </li>
                        <li class="list-group-item">
                            <strong>Intercambio del Authorization Code por un Access Token:</strong>
                            <p>El cliente utilizará el authorization code para obtener el access token. Esto se realiza enviando una solicitud POST al Token Endpoint:</p>
                            <pre><code>POST https://oauthssbb.test/oauth/token</code></pre>
                            <p>Con los siguientes parámetros:</p>
                            <pre><code>grant_type=authorization_code&code=AUTHORIZATION_CODE&redirect_uri=REDIRECT_URI&client_id=CLIENT_ID&client_secret=CLIENT_SECRET</code></pre>
                            <p>El servidor responderá con el siguiente JSON:</p>
                            <pre><code>{
  "access_token": "ACCESS_TOKEN",
  "token_type": "bearer",
  "expires_in": 3600,
  "refresh_token": "REFRESH_TOKEN"
}</code></pre>
                            <ul>
                                <li><code>access_token</code>: Token de acceso que permite acceder a los recursos protegidos.</li>
                                <li><code>expires_in</code>: Tiempo en segundos antes de que el token caduque.</li>
                                <li><code>refresh_token</code>: Token de actualización para obtener nuevos access tokens sin la necesidad de reautenticar al usuario.</li>
                            </ul>
                        </li>
                        <li class="list-group-item">
                            <strong>Acceso a la API protegida:</strong>
                            <p>Una vez obtenido el access token, el cliente podrá hacer solicitudes a la API protegida incluyendo el access token en el encabezado de autorización:</p>
                            <pre><code>GET https://oauthssbb.test/api/recurso Authorization: Bearer ACCESS_TOKEN</code></pre>
                        </li>
                    </ol>
                </div>
                <div class="tab-pane fade" id="list-endpoints" role="tabpanel" aria-labelledby="list-endpoints-list">
                    <h5>4. Endpoints del Servidor OAuth</h5>
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Endpoint</th>
                                <th>Método</th>
                                <th>Descripción</th>
                                <th>Parámetros</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>https://oauthssbb.test/oauth/authorize</code></td>
                                <td><code>GET</code></td>
                                <td>Authorization Endpoint</td>
                                <td>
                                    <ul>
                                        <li><code>response_type</code>: Tipo de respuesta, debe ser <code>code</code></li>
                                        <li><code>client_id</code>: Identificador único de la aplicación cliente</li>
                                        <li><code>redirect_uri</code>: URI a la que el usuario será redirigido después de autorizar la solicitud</li>
                                        <li><code>scope</code>: Permisos solicitados por la aplicación</li>
                                        <li><code>state</code>: Parámetro de seguridad para proteger contra ataques CSRF</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td><code>https://oauthssbb.test/oauth/token</code></td>
                                <td><code>POST</code></td>
                                <td>Token Endpoint</td>
                                <td>
                                    <ul>
                                        <li><code>grant_type</code>: Tipo de concesión, debe ser <code>authorization_code</code></li>
                                        <li><code>code</code>: Authorization code recibido del Authorization Endpoint</li>
                                        <li><code>redirect_uri</code>: URI a la que el usuario fue redirigido después de autorizar la solicitud</li>
                                        <li><code>client_id</code>: Identificador único de la aplicación cliente</li>
                                        <li><code>client_secret</code>: Secreto asociado al Client ID</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td><code>https://oauthssbb.test/api/revoke</code></td>
                                <td><code>POST</code></td>
                                <td>Revocar Tokens Endpoint y eliminar la sesión de OAuth</td>
                                <td>
                                    <ul>
                                        <li><code>token</code>: Token a revocar</li>
                                        <li><code>token_type_hint</code>: Tipo de token, puede ser <code>access_token</code> o <code>refresh_token</code></li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td><code>https://oauthssbb.test/api/revoke-only-token</code></td>
                                <td><code>POST</code></td>
                                <td>Revocar Tokens Endpoint</td>
                                <td>
                                    <ul>
                                        <li><code>token</code>: Token a revocar</li>
                                        <li><code>token_type_hint</code>: Tipo de token, puede ser <code>access_token</code> o <code>refresh_token</code></li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td><code>https://oauthssbb.test/api/user</code></td>
                                <td><code>GET</code></td>
                                <td>Información del usuario</td>
                                <td>
                                    <ul>
                                        <li><code>Authorization</code>: Encabezado de autorización con el token de acceso, formato <code>Bearer ACCESS_TOKEN</code></li>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="list-pasos" role="tabpanel" aria-labelledby="list-pasos-list">
                    <h5>5. Pasos para la Integración del Cliente</h5>
                    <ol class="list-group list-group-numbered mb-3">
                        <li class="list-group-item"><strong>Paso 1:</strong> Solicitar credenciales de acceso</li>
                        <li class="list-group-item"><strong>Paso 2:</strong> Configurar la aplicación cliente</li>
                        <li class="list-group-item"><strong>Paso 3:</strong> Intercambiar el Authorization Code por un Access Token</li>
                        <li class="list-group-item"><strong>Paso 4:</strong> Usar el Access Token</li>
                    </ol>
                </div>
                <div class="tab-pane fade" id="list-notas" role="tabpanel" aria-labelledby="list-notas-list">
                    <h5>6. Notas Importantes</h5>
                    <ul class="list-group mb-3">
                        <li class="list-group-item">Seguridad: Asegúrate de que el Client Secret se mantenga privado y no sea expuesto públicamente.</li>
                        <li class="list-group-item">Redirection URI: Las <code>redirect_uri</code> configuradas en el servidor OAuth deben coincidir exactamente con las especificadas por el cliente, para evitar problemas de redirección no autorizada.</li>
                        <li class="list-group-item">Scopes: Los clientes deben especificar correctamente los scopes de los permisos que desean solicitar. Si el cliente solicita un scope no permitido, el servidor OAuth rechazará la solicitud.</li>
                    </ul>
                </div>
                <div class="tab-pane fade" id="list-problemas" role="tabpanel" aria-labelledby="list-problemas-list">
                    <h5>7. Problemas comunes</h5>
                    <ul class="list-group mb-3">
                        <li class="list-group-item">Redirect URI no coincide: Asegúrate de que la URI configurada en el cliente coincida exactamente con la URI registrada en el servidor OAuth.</li>
                        <li class="list-group-item">Token expirado: Si el access token ha expirado, el cliente debe usar el refresh token para obtener un nuevo access token sin que el usuario tenga que autorizar nuevamente.</li>
                    </ul>
                </div>
                <div class="tab-pane fade" id="list-referencias" role="tabpanel" aria-labelledby="list-referencias-list">
                    <h5>8. Referencias</h5>
                    <ul class="list-group mb-3">
                        <li class="list-group-item">https://laravel.com/docs/11.x/passport</li>
                        <li class="list-group-item">https://oauth2.thephpleague.com/authorization-server/which-grant/</li>
                        <li class="list-group-item">Descargar documento integración.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection