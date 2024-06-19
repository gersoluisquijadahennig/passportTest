<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\RefreshTokenRepository;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

// crear una ruta para cerrar una session activa en el sistema segun el token

Route::delete('/session', function (Request $request, TokenRepository $tokenRepo, RefreshTokenRepository $refreshTokenRepo) {
    $user = $request->user();
    $request->session()->forget('access_token');

    return response()->json(['message' => $user->token()->id], 200);
    if ($user->token()) {
        $tokenId = $user->token()->id;

        // Revoca el token de acceso
        $tokenRepo->revokeAccessToken($tokenId);

        // Revoca todos los tokens de actualización asociados
        $refreshTokenRepo->revokeRefreshTokensByAccessTokenId($tokenId);

        return response()->json(['message' => 'Session cerrada'], 200);
    }

    return response()->json(['message' => 'No autenticado'], 401);
})->middleware('auth:api');