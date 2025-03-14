<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginAdminController;
use App\Http\Controllers\Account\DashboardController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Notifications\CustomResetPasswordNotification;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\Users\UserAdminController;
use App\Http\Controllers\Admin\Realms\RealmAdminController;

Route::prefix('account')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.account');
        Route::post('logout',[LoginController::class,'logout'])->name('logout.account');
        Route::get('login',[LoginController::class,'showLoginForm'])->name('login.account');
        Route::post('login',[LoginController::class,'login']);
        Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
        Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
        Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
        Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::prefix('admin')->group(function () {

    Route::get('login',[LoginAdminController::class,'showLoginForm'])->name('login.admin');
    Route::post('login',[LoginAdminController::class,'login'])->name('login.admin');
    Route::post('logout',[LoginAdminController::class,'logout'])->name('logout.admin');

    Route::prefix('realms')->group(function () {

        Route::get('/', [RealmAdminController::class, 'index'])->name('admin.realm.index')->middleware('auth:admin');
        Route::get('create', [RealmAdminController::class, 'create'])->name('admin.realm.create')->middleware('auth:admin');
        Route::post('store', [RealmAdminController::class, 'store'])->name('admin.realm.store')->middleware('auth:admin');
        Route::get('edit/{realm}', [RealmAdminController::class, 'edit'])->name('admin.realm.edit')->middleware('auth:admin');
        Route::patch('update/{realm}', [RealmAdminController::class, 'update'])->name('admin.realm.update')->middleware('auth:admin');
        Route::delete('destroy/{realm}', [RealmAdminController::class, 'destroy'])->name('admin.realm.destroy')->middleware('auth:admin');
        Route::get('/getrealms', [RealmAdminController::class, 'getRealms'])->middleware('auth:admin')->name('admin.realm.getrealms');

    });

    Route::prefix('{realm_slug}')->middleware(['auth:admin','ensure.realm.access'])->group(function () {

        Route::prefix('dashboard')->group(function () {
            Route::get('/', [DashboardAdminController::class, 'index'])->name('admin.dashboard')->middleware('auth:admin');
        });

        Route::prefix('users')->group(function () {
            Route::get('/', [UserAdminController::class, 'index'])->name('admin.user.index');
            Route::get('create', [UserAdminController::class, 'create'])->name('admin.user.create');
            Route::post('store', [UserAdminController::class, 'store'])->name('admin.user.store');
            Route::get('/getusers', [RealmAdminController::class, 'getUsers'])->middleware('auth:admin')->name('admin.realm.getusers');
        });
    });
});



Route::get('/user', [App\Http\Controllers\UserController::class, 'enviarCorreo'])->name('sendEmail');

Route::get('/notification', function () {

    $user = App\Models.User::find(590);

    $token ="asdlkfasasdfaidyasdifgasdkjhgksdjfgsf234234jh";
    return (new CustomResetPasswordNotification($token))
                ->locale('es')
                ->toMail($user);
});

Route::get('/developer', function () {
    return view('developer');
});