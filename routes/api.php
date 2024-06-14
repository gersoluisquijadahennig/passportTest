<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('/login', function (Request $request) {

    $credentials = $request->only('run', 'clave');
    
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return response()->json($request->user());
    }
    return response()->json([
        'message' => 'Unauthorized'
    ], 401);
});