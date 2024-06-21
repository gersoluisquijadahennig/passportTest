<?php

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

// crear una ruta para validar que exista una session activa en el sistema segun el token
Route::get('/auth', function (Request $request) {
    return response()->json(['auth' => Auth::check()]);
})->middleware('auth:api');

// crear una ruta para obtener las sessiones activas en el sistema segun el token
Route::get('/sessions', function (Request $request) {
    return response()->json(['sessions' => $request->user()->sessions]);
})->middleware('auth:api');

// crear una ruta para cerrar una session activa en el sistema segun el token
Route::delete('/session/{session}', function (Request $request, $session) {
    $session = Auth::user()->sessions()->where('id', $session)->first();
    if ($session) {
        $session->delete();
    }
    return response()->json(['message' => 'Session cerrada']);
})->middleware('auth:api');