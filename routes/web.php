<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
/**
 * agrgamos la ruta para el login
 
 */
Auth::routes();


/*Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);*/


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// vamos a hacer una ruta para mostrar los usuarios registrados en la tabla users y la table usersPanel
Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index')->middleware('auth:api');

