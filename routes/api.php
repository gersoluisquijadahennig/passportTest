<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::get('/user-panel', function (Request $request) {
    return $request->user();
})->middleware('auth:apiPanel');

/**
 * create route for revoke token for user, est
 */

