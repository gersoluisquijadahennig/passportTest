<?php

use App\Models\User;
use App\Models\UserCliente2;
use Illuminate\Http\Request;
use App\Models\Passport\Sesion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

use Illuminate\Support\Facades\Route;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\RefreshTokenRepository;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::get('/user-cliente2', function (Request $request) {

    if (Gate::allows('cliente_2', $request->user())) {
        try{
            $usuario_cliente2 = UserCliente2::where('run', $request->user()->run)->first();
            return $usuario_cliente2;
        }catch(\Exception $e){
            return response()->json([
                'error' => 'Error al obtener el usuario cliente2: ' . $e->getMessage()
            ], 500);
        }

    } else {
        return response()->json([
            'error' => 'No tiene permisos para acceder a este recurso'
        ], 403);
    }
})->middleware('auth:api', 'scopes:cliente2');

Route::get('/user-cliente3', function (Request $request)
{

    return $request->user();

})->middleware('auth:api', 'scopes:cliente3');

Route::post('/revoke', function (Request $request)
{
    try {
        $user = $request->user();

        $tokens = $user->tokens;

        foreach ($tokens as $token) {
            $tokenRepository = app(TokenRepository::class);
            $refreshTokenRepository = app(RefreshTokenRepository::class);

            $tokenRepository->revokeAccessToken($token->id);
            $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($token->id);
        }

        Sesion::where('user_id', $user->id)->delete();

        return response()->json([
            'message' => 'Todos los tokens y sesiones han sido revocados correctamente.'
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Error al revocar tokens y sesiones: ' . $e->getMessage()
        ], 500);
    }
})->middleware('auth:api');

Route::post('/revoke-only-token', function (Request $request) {
    try {
        $user = $request->user();

        $tokens = $user->tokens;

        foreach ($tokens as $token) {
            $tokenRepository = app(TokenRepository::class);
            $refreshTokenRepository = app(RefreshTokenRepository::class);

            $tokenRepository->revokeAccessToken($token->id);
            $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($token->id);
        }

        return response()->json([
            'message' => 'Todos los tokens y sesiones han sido revocados correctamente.'
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Error al revocar tokens y sesiones: ' . $e->getMessage()
        ], 500);
    }
})->middleware('auth:api');

/*Route::get('/verificar-cliente', function (Request $request) {
    return response()->json([
        'message' => 'Token válido para consesión de cliente. maquina a maquina.'
    ], 200);
})->middleware('client');*/

Route::get('/session', function (Request $request) {
    $user = $request->user();
    $session = Sesion::where('user_id', $user->id)->first();
    return response()->json([
        'session' => $session,
        'payload' => unserialize(base64_decode($session->payload))
    ], 200);
})->middleware('auth:api');

/*Route::get('/token/{token_id}', function ($token_id) {
    try {
        $token = \Laravel\Passport\Token::find($token_id);

        if (!$token) {
            return response()->json([
                'message' => 'Token no encontrado'
            ], 404);
        }

        // Generar un nuevo token de acceso utilizando el mismo token
        $user = $token->user;
        $newAccessToken = $user->createToken('New Token')->accessToken;

        return response()->json([
            'token' => [
                'id' => $token->id,
                'user_id' => $token->user_id,
                'client_id' => $token->client_id,
                'expires_at' => $token->expires_at,
                'revoked' => $token->revoked
            ],
            'access_token' => $newAccessToken
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Error al consultar el token',
            'error' => $e->getMessage()
        ], 500);
    }
})->middleware('auth:api');*/

/*Route::get('/test-redis', function (Request $request) {
    try {
        $user = $request->user();
        $testKey = "test:{$user->id}";

        // Test set
        Redis::set($testKey, 'test-value');

        // Test get
        $value = Redis::get($testKey);

        // Test get token
        $userToken = Redis::get($user->id);

        return response()->json([
            'success' => true,
            'redis_test_value' => $value,
            'user_token' => $userToken,
            'test_key' => $testKey
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Redis test failed',
            'error' => $e->getMessage()
        ], 500);
    }
})->middleware('auth:api');*/

