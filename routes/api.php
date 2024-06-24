<?php

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\RefreshTokenRepository;

use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::delete('/revoketoken', function (Request $request) {
 //dd($request->user());
 try {
    $user = $request->user();

    $tokenId = $user->token()->id;
    $tokenRepository = app(TokenRepository::class);
    $refreshTokenRepository = app(RefreshTokenRepository::class);

    // Revocar el token de acceso
    $tokenRepository->revokeAccessToken($tokenId);
    // Revocar todos los tokens de actualización asociados
    $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($tokenId);

    return response()->json([
        'message' => 'Tokéns revocados correctamente.'
    ], 200);
} catch (\Exception $e) {
    // Manejo de excepciones generales
    return response()->json([
        'error' => 'Ocurrió un error al revocar el token y cerrar la sesión. ' . $e->getMessage()
    ], 500);
}})->middleware('auth:api');
